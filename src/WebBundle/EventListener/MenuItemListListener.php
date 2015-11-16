<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 03/11/2015
 * Time: 05:14
 */

namespace WebBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Avanzu\AdminThemeBundle\Model\MenuItemModel;
use Symfony\Component\HttpFoundation\Request;

class MenuItemListListener{

    /**
     * @param SidebarMenuEvent $event
     */
    public function onSetupMenu(SidebarMenuEvent $event) {

        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function getMenu(Request $request) {

        $menuItems = array(
            'home' =>  new MenuItemModel('home', 'Home', 'app_homepage', array(), 'fa fa-home'),
            'market'    =>  new MenuItemModel('markets', 'Markets', 'dr_market_list', array(), 'fa fa-line-chart'),
            'settings'  => new MenuItemModel('settings', 'Settings', '', array(), 'fa fa-cogs'),

        );

        /**
         * @var MenuItemModel
         */
        $menuItems['settings']
            ->addChild(new MenuItemModel('settings_refresher', 'Refresher', 'dr_settings_refresher', array(), 'fa fa-clock-o'))
            ->addChild(new MenuItemModel('settings_assets', 'Assets', 'dr_settings_asset', array(), 'fa fa-money'))
        ;

        return $this->activateByRoute($request->get('_route'), $menuItems);
    }

    /**
     * @param $route
     * @param $items
     * @return mixed
     */
    protected function activateByRoute($route, $items) {

        foreach($items as $item) {
            if($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            }
            else {
                if($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }

        return $items;
    }

}
