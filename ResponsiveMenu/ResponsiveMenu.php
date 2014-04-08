<?php

/**
 * Responsive Retina-Ready Menu wrapper fo Yii framework
 * @see http://tympanus.net/codrops/2013/05/08/responsive-retina-ready-menu/
 */
class ResponsiveMenu extends CWidget
{
    /**
     * @var bool - include modernizr library or not
     */
    public $includeModernizr = false;
    /**
     * @var array - wrapper nav tag options
     */
    public $navOptions = array(
        //'id'    => 'menu',
        'class' => 'nav',
    );
    public $wrapperOptions = array(
        'class' => 'responsive-menu-wrapper',
    );
    /**
     * @var array - menu list tag options
     */
    public $listOptions = array();
    
    /**
     * @var array - menu items
     *              each menu item is an array, containing item options
     * Example:
     * array(
     *     // menu item with text only
     *     [0] => array(
     *         'url'  => 'http://example.com/section1',
     *         'text' => 'Menu Item',
     *         'linkOptions' => array('target' => '_blank'),
     *     ),
     *     // menu item with text and icon
     *     [1] => array(
     *         'url'  => 'http://example.com/section2',
     *         'text' => 'Menu Item',
     *         'icon' => '<i aria-hidden="true" class="icon-services"></i>', // you can also use any custom html here
     *         'linkOptions' => array('target' => '_blank'),
     *     ),
     *     // menu item with custom html content
     *     [2] => array(
     *         'url'  => 'http://example.com/section3',
     *         'html' => '<span class="icon"><i aria-hidden="true" class="icon-services"></i></span><span>Menu Item</span>',
     *         'linkOptions' => array('target' => '_blank'),
     *     ),
     * )
     */
    protected $items;
    /**
     * @var string
     */
    protected $assetUrl;
    
    /**
     * @see CWidget::init()
     */
    public function init()
    {
        $this->assetUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.ResponsiveMenu.assets'));
        
        Yii::app()->clientScript->registerCssFile($this->assetUrl.'/css/component.css');
        if ( $this->includeModernizr )
        {// modernizr library is very popular, and can be already included in your project
            Yii::app()->clientScript->registerScriptFile($this->assetUrl.'/js/modernizr.custom.js');
        }
    }
    
    /**
     * @see CWidget::run()
     */
    public function run()
    {
        $this->render('menu');
    }
    
    /**
     * Setter for menu items
     * @param array $items - menu items
     * @return void
     */
    public function setItems($items)
    {
        if ( ! is_array($items) OR empty($items) )
        {
            throw new CException('Error: menu items not set');
        }
        $this->items = $items;
    }
    
    /**
     * Compose internal html item content
     * @param array $item
     * @return string 
     */
    protected function getItemContent($item)
    {
        $content     = '';
        $url         = '#';
        $linkOptions = array();
        if ( isset($item['linkOptions']) AND is_array($item['linkOptions']) )
        {
            $linkOptions = $item['linkOptions'];
        }
        if ( isset($item['url']) )
        {
            $url = $item['url'];
        }
        
        if ( isset($item['html']) )
        {// item with custom html content
            $content = $item['html'];
        }elseif ( isset($item['text']) AND isset($item['icon']) )
        {// item with text and icon
            // icon span
            $content .= CHtml::openTag('span', array('class' => 'icon'));
            $content .= $item['icon'];
            $content .= CHtml::closeTag('span');
            // text span
            $content .= CHtml::openTag('span');
            $content .= $item['text'];
            $content .= CHtml::closeTag('span');
        }elseif ( isset($item['text']) AND ! isset($item['icon']) )
        {// item with text only
            $content .= CHtml::openTag('span');
            $content .= $item['text'];
            $content .= CHtml::closeTag('span');
        }else
        {// incorrect function argument
            throw new CException('Error: wrong menu item content');
        }
        
        return CHtml::link($content, $url, $linkOptions);
    }
}