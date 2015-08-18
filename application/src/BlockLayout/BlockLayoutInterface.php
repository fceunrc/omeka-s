<?php
namespace Omeka\BlockLayout;

use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Entity\SitePageBlock;
use Omeka\Stdlib\ErrorStore;
use Zend\View\Renderer\PhpRenderer;

interface BlockLayoutInterface
{
    /**
     * Get a human-readable label for the block layout.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Prepare the view to enable the block layout form.
     *
     * Typically used to append JavaScript to the head.
     *
     * @param PhpRenderer $view
     */
    public function prepareForm(PhpRenderer $view);

    /**
     * Process and validate block data.
     *
     * @param SitePageBlock $block
     * @param ErrorStore $errorStore
     */
    public function ingest(SitePageBlock $block, ErrorStore $errorStore);

    /**
     * Render a form for adding/editing a block.
     *
     * @param PhpRenderer $view
     * @param int $index The block index on the form
     * @param SitePageBlockRepresentation $block
     * @return string
     */
    public function form(PhpRenderer $view, $index, SitePageBlockRepresentation $block = null);

    /**
     * Render the provided block.
     *
     * @param PhpRenderer $view
     * @param SitePageBlockRepresentation $block
     * @return string
     */
    public function render(PhpRenderer $view, SitePageBlockRepresentation $block);
}