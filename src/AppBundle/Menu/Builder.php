<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array (
                'class' => 'nav navbar-nav',
            ),
        ));

        $menu->addChild('<i class="fa fa-home"></i>', [
            'route' => 'homepage',
            'extras' => ['safe_label' => true]
        ])
        ->setLinkAttribute('class', 'home');

        $menu->addChild('Giới thiệu', [
            'route' => 'news_show',
            'routeParameters' => ['slug' => 'gioi-thieu']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');

        $menu['Giới thiệu']->addChild('Về chúng tôi', [
            'route' => 'news_show',
            'routeParameters' => ['slug' => 'gioi-thieu']
        ]);

        $menu['Giới thiệu']->addChild('Chính sách chất lượng', [
            'route' => 'news_show',
            'routeParameters' => ['slug' => 'chinh-sach-chat-luong']
        ]);

        $menu['Giới thiệu']->addChild('Tuyển dụng', [
            'route' => 'news_show',
            'routeParameters' => ['slug' => 'tuyen-dung']
        ]);

        $menu->addChild('Sửa chữa nhà', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'sua-chua-nha']
        ]);

        $menu->addChild('Xây dựng', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'xay-dung']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');

        $menu['Xây dựng']->addChild('Nhà phố', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'xay-dung']
        ]);

        $menu['Xây dựng']->addChild('Dự toán chi phí', [
            'route' => 'caculator_cost_construction'
        ]);

        $menu['Xây dựng']->addChild('Chính sách bảo hành', [
            'route' => 'news_show',
            'routeParameters' => ['slug' => 'chinh-sach-bao-hanh']
        ]);

        $menu->addChild('Thiết kế', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'thiet-ke']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');

        $menu['Thiết kế']->addChild('Thiết kế quán cafe', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'thiet-ke', 'level2' => 'thiet-ke-thi-cong-quan-cafe']
        ]);

        $menu->addChild('Phong thủy xây dựng', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'phong-thuy-xay-dung']
        ]);

        $menu->addChild('Dự án thi công', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'du-an']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');
        
        $menu['Dự án thi công']->addChild('Xây mới', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'du-an', 'level2' => 'xay-moi']
        ]);
        $menu['Dự án thi công']->addChild('Sửa chữa', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'du-an', 'level2' => 'sua-chua']
        ]);
        $menu['Dự án thi công']->addChild('Quán cafe, trà sữa', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'du-an', 'level2' => 'quan-cafe-tra-sua']
        ]);

        $menu->addChild('Tư vấn', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'tu-van']
        ]);

        // Contact us
        $menu->addChild('Liên hệ', [
            'route' => 'contact'
        ]);

        return $menu;
    }

    public function footerMenu(FactoryInterface $factory, array $options)
    {
        $footerMenu = $factory->createItem('root');

        return $footerMenu;
    }
}