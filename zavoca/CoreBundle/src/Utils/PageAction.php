<?php


namespace Zavoca\CoreBundle\Utils;


class PageAction
{
    const INFO = 'btn-info';
    const SUCCESS = 'btn-success';
    const PRIMARY = 'btn-primary';
    const DANGER = 'btn-danger';
    const SECONDARY = 'btn-secondary';


    const PROMPT_SUCCESS = 'success';
    const PROMPT_ERROR = 'error';
    const PROMPT_WARNING = 'warning';
    const PROMPT_INFO = 'info';
    const PROMPT_QUESTION = 'question';


    protected $pageAction;

    public function __construct($label, $link, $type, $iconCode = null, $prompt = false, $promptMessage = "Are You Sure ?", $promptConfirm = true, $promptSign = self::PROMPT_INFO, $promptCancel = true)
    {
        /**
         * difference between promptOk and promptConfirm
         *
         *
         * promptOk : will only display the message and won't trigger the button as  GO TO THE LINK
         *
         *
         * promptConfirm : will continue executing the button's action, that is GO TO THE LINK
         *
         *
         */
        $this->pageAction = [
            'label' => $label,
            'icon' => $iconCode,
            'link' => $link,
            'type' => $type,
            'prompt' => $prompt,
            'promptSettings' => [
                'sign' => $promptSign,
                'message' => $promptMessage,
                'button_confirm' => $promptConfirm?'prompt-confirm':'prompt-ok',
                'button_cancel' => $promptCancel?'prompt-cancel':'no'
            ]
        ];
    }

    /**
     * @return array
     */
    public function getPageAction(): array
    {
        return $this->pageAction;
    }

    /**
     * @param array $pageAction
     */
    public function setPageAction(array $pageAction): void
    {
        $this->pageAction = $pageAction;
    }
}