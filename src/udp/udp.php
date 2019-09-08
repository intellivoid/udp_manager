<?php


    namespace udp;

    use udp\Classes\DisplayPictureGenerator;

    include_once(__DIR__ . DIRECTORY_SEPARATOR  . 'Interfaces' . DIRECTORY_SEPARATOR . 'GeneratorInterface.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . 'BaseGenerator.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . 'GdGenerator.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . 'DisplayPictureGenerator.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . 'SvgGenerator.php');

    /**
     * Class udp
     * @package udp
     */
    class udp
    {
        /**
         * @var DisplayPictureGenerator
         */
        private $displayPictureGenerator;

        public function __construct()
        {
            $this->displayPictureGenerator = new DisplayPictureGenerator();
        }

        /**
         * @return DisplayPictureGenerator
         */
        public function getDisplayPictureGenerator()
        {
            return $this->displayPictureGenerator;
        }
    }