<?php
/**
 * DokuWiki Plugin top (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Gohr <gohr@cosmocode.de>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_top extends DokuWiki_Action_Plugin {

    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(Doku_Event_Handler $controller) {
        global $ACT;
        global $JSINFO;
        $JSINFO['act'] = $ACT;
        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, 'handle_ajax_call_unknown');
   
    }

    /**
     * [Custom event handler which performs action]
     *
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     * @return void
     */

    public function handle_ajax_call_unknown(Doku_Event &$event, $param) {
        if($event->data != 'plugin_top') return;
        $event->preventDefault();
        $event->stopPropagation();

        global $INPUT;
        $page = cleanID($INPUT->str('page'));
        if(!$page) return;

        /** @var helper_plugin_top $hlp */
        $hlp = plugin_load('helper', 'top');
        $hlp->add($page);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'counted';
    }

}

// vim:ts=4:sw=4:et:
