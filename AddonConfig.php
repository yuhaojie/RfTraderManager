<?php
namespace addons\RfTraderManager;

/**
 * Class Addon
 * @package addons\RfSignShoppingDay
 */
class AddonConfig
{
    /**
     * 配置信息
     *
     * @var array
     */
    public $info = [
        'name' => 'RfTraderManager',
        'title' => '推广管理',
        'brief_introduction' => '管理推广',
        'description' => '管理推广渠道和人员',
        'author' => '简言',
        'version' => '1.0.0',
    ];

    /**
     * 可授权权限
     *
     * 例子：
     *  array(
     *      'index/index' => '首页',
     *      'index/edit' => '首页编辑',
     *  )
     * @var array
     */
    public $authItem = [
        'trader/index' => '销售管理',
        'trader/logon' => '销售登录',
        'market/index' => '考勤管理',
        'market/record' => '考勤录入',
        'channel/index' => '渠道管理',
        'channel/add' => '增加渠道',
    ];

    /**
     * 参数配置
     *
     * @var bool
     */
    public $isSetting = true;

    /**
     * 钩子
     *
     * @var bool
     */
    public $isHook = false;

    /**
     * 小程序
     *
     * @var bool
     */
    public $isMiniProgram = false;

    /**
     * 规则管理
     *
     * @var bool
     */
    public $isRule = false;

    /**
     * 类别
     *
     * @var string
     * [
     *      'plug'      => "功能插件",
     *      'business'  => "主要业务",
     *      'customer'  => "客户关系",
     *      'activity'  => "营销及活动",
     *      'services'  => "常用服务及工具",
     *      'biz'       => "行业解决方案",
     *      'h5game'    => "H5游戏",
     *      'other'     => "其他",
     * ]
     */
    public $group = 'activity';

    /**
     * 微信接收消息类别
     *
     * @var array
     * 例如 : ['image','voice','video','shortvideo']
     */
    public $wechatMessage = [];

    /**
     * 后台菜单
     *
     * 例如
     * public $menu = [
     *  [
     *      'title' => '基本表格',
     *      'route' => 'curd-base/index',
     *      'icon' => ''
     *   ]
     * ]
     * @var array
     */
    public $menu = [
        [
            'title' => '销售管理',
            'route' => 'trader/index',
            'icon' => '',
        ],
        [
            'title' => '销售登录',
            'route' => 'trader/logon',
            'icon'  => '',
        ],
        [
            'title' => '考勤管理',
            'route' => 'market/index',
            'icon' => ''
        ],
        [
            'title' => '考勤录入',
            'route' => 'market/record',
            'icon' => ''
        ],
        [
            'title' => '渠道管理',
            'route' => 'channel/index',
            'icon' => ''
        ],
        [
            'title' => '增加渠道',
            'route' => 'channel/add',
            'icon' => ''
        ],
    ];

    /**
     * 同menu上
     *
     * @var array
     */
    public $cover = [
        [
            'title' => '首页导航',
            'route' => 'index/index',
            'icon' => ''
        ],
    ];

    /**
     * 保存在当前模块的根目录下面
     *
     * 例如 public $install = 'install.php';
     * 安装SQL,只支持php文件
     * @var string
     */
    public $install = 'install.php';
    
    /**
     * 卸载SQL
     *
     * @var string
     */
    public $uninstall = 'uninstall.php';
    
    /**
     * 更新SQL
     *
     * @var string
     */
    public $upgrade = 'upgrade.php';
}
            