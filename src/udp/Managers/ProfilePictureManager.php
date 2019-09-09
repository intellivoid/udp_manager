<?php


    namespace udp\Managers;

    use Exception;
    use udp\Abstracts\ImageType;
    use udp\Classes\ImageProcessor;
    use udp\Classes\SecurityVerification;
    use udp\Exceptions\ImageTooSmallException;
    use udp\Exceptions\InvalidImageException;
    use udp\Exceptions\UnsupportedFileTypeException;
    use udp\udp;

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
         * @var udp
         */
        private $udp;

        /**
         * @var string
         */
        private $tmp_location;

        /**
         * ProfilePictureManager constructor.
         * @param string $storage_location
         * @param string $tmp_location
         * @param udp $udp
         */
        public function __construct(string $storage_location, string $tmp_location, udp $udp)
        {
            $this->storage_location = $storage_location;
            $this->tmp_location = $tmp_location;
            $this->udp = $udp;
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
            $OutputFile = $Directory .  'preview.jpg';
            if(file_exists($OutputFile))
            {
                unlink($OutputFile);
            }
            copy($file, $OutputFile);

            ImageProcessor::resize_image($file, 160, 160);
            $OutputFile = $Directory . 'small.jpg';
            if(file_exists($OutputFile))
            {
                unlink($OutputFile);
            }
            copy($file, $OutputFile);

            ImageProcessor::resize_image($file, 64, 64);
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

        /**
         * @param string $id
         * @return bool
         * @throws ImageTooSmallException
         * @throws InvalidImageException
         * @throws UnsupportedFileTypeException
         * @throws Exception
         */
        public function generate_avatar(string $id): bool
        {
            $OutputFile = $this->tmp_location . DIRECTORY_SEPARATOR . $id . '.png';
            $ImageResource = $this->udp->getDisplayPictureGenerator()->getImageData($id, 640);
            file_put_contents($this->tmp_location . DIRECTORY_SEPARATOR . $id . '.png', $ImageResource);
            $this->apply_avatar($OutputFile, $id);
            return true;
        }

        /**
         * Determines if the avatar exists
         *
         * @param string $id
         * @return bool
         */
        public function avatar_exists(string $id): bool
        {
            $Directory = $this->storage_location . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;

            if(file_exists($Directory) == false)
            {
                return false;
            }

            if(file_exists($Directory . 'original.jpg') == false)
            {
                return false;
            }

            if(file_exists($Directory . 'normal.jpg') == false)
            {
                return false;
            }

            if(file_exists($Directory . 'preview.jpg') == false)
            {
                return false;
            }

            if(file_exists($Directory . 'small.jpg') == false)
            {
                return false;
            }

            if(file_exists($Directory . 'tiny.jpg') == false)
            {
                return false;
            }

            return true;
        }
    }