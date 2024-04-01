<?php
if (!function_exists('calculateRotationAngle')) {
    function calculateRotationAngle($imgPath)
    {
        // Your logic to calculate rotation angle based on the image path
        $extension = pathinfo($imgPath, PATHINFO_EXTENSION);

        return ($extension == 'png') ? 90 : 0; // Rotate by 90 degrees if it's a PNG, otherwise no rotation
    }
}
?>