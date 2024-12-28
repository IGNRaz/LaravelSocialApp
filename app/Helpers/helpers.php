
<?php

if (!function_exists('getProfilePictureUrl')) {
    function getProfilePictureUrl($user) {
        return Storage::url($user->profile_picture);
    }
}