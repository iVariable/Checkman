<?php
namespace Budget\ApplicationBundle\Twig\Extension;

class Common extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            'pad' => new \Twig_Filter_Function('str_pad'),
            'md5' => new \Twig_Filter_Function('md5'),
            'jsonEncode' => new \Twig_Filter_Function('json_encode'),
            'jsonDecode' => new \Twig_Filter_Function('json_decode'),
            'round' => new \Twig_Filter_Function('round'),
            'trim' => new \Twig_Filter_Function('trim'),
            'ltrim' => new \Twig_Filter_Function('ltrim'),
            'rtrim' => new \Twig_Filter_Function('rtrim'),
            'substring' => new \Twig_Filter_Function('substr'),
            'dump' => new \Twig_Filter_Function('var_dump'),
            'shift' => new \Twig_Filter_Function('array_shift'),
            'pop' => new \Twig_Filter_Function('array_pop'),
            'count' => new \Twig_Filter_Function('count'),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'common';
    }
}