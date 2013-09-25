<?php
/**
 * Observer - Hook into Magento's CMS Blocks Output and set caching options.
 * @category Wargento
 * @package Wargento_Cache
 * @author Gabriel C. (lazycoder.ro[at]gmail.com / http://lazycoder.ro)
 * @since 25.09.13
 */
class Wargento_Cache_Model_Observer
{
    /**
     * Set cache data.
     * @event core_block_abstract_to_html_before
     * @param \Varien_Event_Observer $observer
     * @return \Wargento_Cache_Model_Observer
     */
    public function cacheStaticCmsBlocks(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();
        $block = $event->getBlock();
        if($block instanceof Mage_Cms_Block_Block
            || $block instanceof Mage_Cms_Block_Widget_Block) {
//            Varien_Profiler::start('set_caching_static_cms_blocks_' . $block->getBlockId());
            $block->addData(array(
                'cache_tags'        => array(Mage_Cms_Model_Block::CACHE_TAG),
                'cache_keys'        => '_cms_block' . $block->getBlockId() . Mage::app()->getStore()->getId(),
                'cache_lifetime'    => false,
                )
            );
//            Varien_Profiler::stop('set_caching_static_cms_blocks_' . $block->getBlockId());
        }
        
        return $this;
    }
}
