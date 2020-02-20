<?php

/**
 * Shown in the Post page (called from SQ_Controllers_Menu)
 *
 */
class SQ_Models_Post {

    /**
     * Search for posts in the local blog
     *
     * @param array $args
     * @return array|WP_Error
     */
    public function searchPost($args) {
        wp_reset_query();
        $wp_query = new WP_Query($args);
        return $wp_query->get_posts();
    }

    /**
     * Returns the attachment from the file URL
     *
     * @param $image_url
     * @return mixed
     */
    function findAttachmentByUrl($image_url) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE `post_type` = 'attachment' AND `guid` like '%%%s';", $image_url));
    }

    /**
     * Add the image for Open Graph
     *
     * @param string $file
     * @return array [name (the name of the file), image (the path of the image), message (the returned message)]
     *
     */
    function addImage(&$file, $overrides = false, $time = null) {
        // The default error handler.
        if (!function_exists('wp_handle_upload_error')) {

            function wp_handle_upload_error(&$file, $message) {
                return array('error' => $message);
            }

        }

        /**
         * Filter data for the current file to upload.
         *
         * @since 2.9.0
         *
         * @param array $file An array of data for a single file.
         */
        $file = apply_filters('wp_handle_upload_prefilter', $file);

        // You may define your own function and pass the name in $overrides['upload_error_handler']
        $upload_error_handler = 'wp_handle_upload_error';

        // You may have had one or more 'wp_handle_upload_prefilter' functions error out the file. Handle that gracefully.
        if (isset($file['error']) && !is_numeric($file['error']) && $file['error'])
            return $upload_error_handler($file, $file['error']);

        // You may define your own function and pass the name in $overrides['unique_filename_callback']
        $unique_filename_callback = null;

        // $_POST['action'] must be set and its value must equal $overrides['action'] or this:
        $action = 'sq_save_ogimage';

        // Courtesy of php.net, the strings that describe the error indicated in $_FILES[{form field}]['error'].
        $upload_error_strings = array(false,
            __("The uploaded file exceeds the upload_max_filesize directive in php.ini."),
            __("The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form."),
            __("The uploaded file was only partially uploaded."),
            __("No file was uploaded."),
            '',
            __("Missing a temporary folder."),
            __("Failed to write file to disk."),
            __("File upload stopped by extension."));

        // All tests are on by default. Most can be turned off by $overrides[{test_name}] = false;
        $test_form = true;
        $test_size = true;
        $test_upload = true;

        // If you override this, you must provide $ext and $type!!!!
        $test_type = true;
        $mimes = false;

        // Install user overrides. Did we mention that this voids your warranty?
        if (is_array($overrides))
            extract($overrides, EXTR_OVERWRITE);

        // A correct form post will pass this test.
        if ($test_form && (!isset($_POST['action']) || ($_POST['action'] != $action)))
            return call_user_func($upload_error_handler, $file, __('Invalid form submission.'));

        // A successful upload will pass this test. It makes no sense to override this one.
        if (isset($file['error']) && $file['error'] > 0) {
            return call_user_func($upload_error_handler, $file, $upload_error_strings[$file['error']]);
        }

        // A non-empty file will pass this test.
        if ($test_size && !($file['size'] > 0)) {
            if (is_multisite())
                $error_msg = __('File is empty. Please upload something more substantial.');
            else
                $error_msg = __('File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.');
            return call_user_func($upload_error_handler, $file, $error_msg);
        }

        // A properly uploaded file will pass this test. There should be no reason to override this one.
        if ($test_upload && !@ is_uploaded_file($file['tmp_name']))
            return call_user_func($upload_error_handler, $file, __('Specified file failed upload test.'));

        // A correct MIME type will pass this test. Override $mimes or use the upload_mimes filter.
        if ($test_type) {
            $wp_filetype = wp_check_filetype_and_ext($file['tmp_name'], $file['name'], $mimes);

            extract($wp_filetype);

            // Check to see if wp_check_filetype_and_ext() determined the filename was incorrect
            if (isset($proper_filename) && $proper_filename <> '')
                $file['name'] = $proper_filename;

            if ((!isset($type) || !isset($ext)) && !current_user_can('unfiltered_upload'))
                return call_user_func($upload_error_handler, $file, __('Sorry, this file type is not permitted for security reasons.'));

            if (!$ext)
                $ext = ltrim(strrchr($file['name'], '.'), '.');

            if (!$type)
                $type = $file['type'];
        } else {
            $type = '';
        }

        // A writable uploads dir will pass this test. Again, there's no point overriding this one.
        if (!(($uploads = wp_upload_dir($time)) && false === $uploads['error']))
            return call_user_func($upload_error_handler, $file, $uploads['error']);

        $filename = wp_unique_filename($uploads['path'], $file['name'], $unique_filename_callback);

        // Move the file to the uploads dir
        $new_file = $uploads['path'] . "/$filename";
        if (false === @ move_uploaded_file($file['tmp_name'], $new_file)) {
            if (0 === strpos($uploads['basedir'], ABSPATH))
                $error_path = str_replace(ABSPATH, '', $uploads['basedir']) . $uploads['subdir'];
            else
                $error_path = basename($uploads['basedir']) . $uploads['subdir'];

            return $upload_error_handler($file, sprintf(__('The uploaded file could not be moved to %s.'), $error_path));
        }

        // Set correct file permissions
        $stat = stat(dirname($new_file));
        $perms = $stat['mode'] & 0000666;
        @ chmod($new_file, $perms);

        // Compute the URL
        $url = $uploads['url'] . "/$filename";

        if (is_multisite())
            delete_transient('dirsize_cache');

        /**
         * Filter the data array for the uploaded file.
         *
         * @since 2.1.0
         *
         * @param array $upload {
         *     Array of upload data.
         *
         * @type string $file Filename of the newly-uploaded file.
         * @type string $url URL of the uploaded file.
         * @type string $type File type.
         * }
         * @param string $context The type of upload action. Accepts 'upload' or 'sideload'.
         */
        return apply_filters('wp_handle_upload', array('file' => $new_file, 'url' => $url, 'type' => $type), 'upload');
    }

    /**
     * Upload the image on server from version 2.0.4
     *
     * Add configuration page
     */
    public function upload_image($url) {
        if (strpos($url, 'http') === false && strpos($url, '//') !== false) {
            $url = 'http:' . $url;
        }

        $filename = false;
        $response = wp_remote_get($url, array('timeout' => 15));
        $body = wp_remote_retrieve_body($response);
        $type = wp_remote_retrieve_header($response, 'content-type');

        $extension = pathinfo($url, PATHINFO_EXTENSION);
        $mimes = get_allowed_mime_types();
        foreach ($mimes as $extensions => $mime) {
            if (in_array($extension, explode('|', $extensions))) {
                $filename = md5(basename($url)) . '.' . $extension;
                break;
            }
        }
        if (!$filename) {
            foreach ($mimes as $extensions => $mime) {
                if ($mime == $type) {
                    $filename = md5(basename($url)) . '.' . current(explode('|', $extensions));
                    break;
                }
            }
        }

        if (!$filename) return false;

        $file = wp_upload_bits($filename, '', $body, null);

        if (!isset($file['error']) || $file['error'] == '')
            if (isset($file['url']) && $file['url'] <> '') {
                $file['filename'] = $filename;
                $file['type'] = $type;
                return $file;
            }

        return false;
    }

}
