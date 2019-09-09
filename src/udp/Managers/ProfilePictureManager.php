<?php


    namespace udp\Managers;

    use udp\Abstracts\ImageType;
    use udp\Classes\ImageProcessor;
    use udp\Classes\SecurityVerification;
    use udp\Exceptions\ImageTooSmallException;
    use udp\Exceptions\InvalidImageException;
    use udp\Exceptions\UnsupportedFileTypeException;

    /**
     * Class ProfilePictureManager
     * @package udp\Managers
     */
    class ProfilePictureManager
    {
        /**
         * @var string
         */
        private $storage_location;

        /**
         * ProfilePictureManager constructor.
         * @param string $storage_location
         */
        public function __construct(string $storage_location)
        {
            $this->storage_location = $storage_location;
        }

        /**
         * Applies an avatar to a unique ID
         *
         * @param string $file
         * @param string $id
         * @return bool
         * @throws InvalidImageException
         * @throws UnsupportedFileTypeException
         * @throws ImageTooSmallException
         */
        public function apply_avatar(string $file, string $id): bool
        {
            $ImageDetails = SecurityVerification::verify_image($file);
            if($ImageDetails->Width < 360 || $ImageDetails->Height < 360)
            {
                throw new ImageTooSmallException();
            }

            // Convert to JPEG if needed
            if($ImageDetails->ImageType == ImageType::PNG)
            {
                ImageProcessor::convert($file);
            }

            $Directory = $this->storage_location . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;
            if(file_exists($Directory) == false)
            {
                mkdir($Directory);
            }

            // Apply the original
            $OutputFile = $Directory . 'original.jpg';
            if(file_exists($OutputFile))
            {
                unlink($OutputFile);
            }
            copy($file, $OutputFile);

            // Resize and apply the resized version
            ImageProcessor::resize_image($file, 640, 640);
            $OutputFile = $Directory . 'normal.jpg';
            if(file_exists($OutputFile))
            {
                unlink($OutputFile);
            }
            copy($file, $OutputFile);

            ImageProcessor::resize_image($file, 360, 360);
            $OutputFile = $Directory .  'small.jpg';
            if(file_exists($OutputFile))
            {
                unlink($OutputFile);
            }
            copy($file, $OutputFile);

            ImageProcessor::resize_image($file, 160, 160);
            $OutputFile = $Directory . 'tiny.jpg';
            if(file_exists($OutputFile))
            {
                unlink($OutputFile);
            }
            copy($file, $OutputFile);

            // Finally delete the temporary file
            unlink($file);
            return true;
        }
    }