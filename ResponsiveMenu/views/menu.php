<?php
/**
 * Menu layout
 */
/* @var $this ResponsiveMenu */


echo CHtml::openTag('nav', $this->wrapperOptions);
echo CHtml::openTag('nav', $this->navOptions);
echo CHtml::openTag('ul', $this->listOptions);
foreach ( $this->items as $item )
{
    echo CHtml::openTag('li');
    echo $this->getItemContent($item);
    echo CHtml::closeTag('li');
}
echo CHtml::closeTag('ul');
echo CHtml::closeTag('nav');
echo CHtml::closeTag('div');