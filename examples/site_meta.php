<?php

/**
 * SiteMeta - 站点元信息管理工具
 * 
 * 使用数组保存站点元信息，并提供生成简短描述文本的方法
 */

class SiteMeta {
    
    /**
     * 站点元信息数组
     *
     * @var array
     */
    private $meta = [];
    
    /**
     * 构造函数
     *
     * @param array $meta 初始元信息
     */
    public function __construct(array $meta = []) {
        $this->meta = $meta;
    }
    
    /**
     * 设置元信息
     *
     * @param string $key 键名
     * @param mixed $value 值
     * @return void
     */
    public function set($key, $value) {
        $this->meta[$key] = $value;
    }
    
    /**
     * 获取元信息
     *
     * @param string $key 键名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get($key, $default = null) {
        return isset($this->meta[$key]) ? $this->meta[$key] : $default;
    }
    
    /**
     * 生成站点简短描述文本
     *
     * @param int $maxLength 最大长度
     * @return string
     */
    public function generateDescription($maxLength = 160) {
        $parts = [];
        
        // 站点标题
        $title = $this->get('title', '');
        if (!empty($title)) {
            $parts[] = $title;
        }
        
        // 站点描述
        $desc = $this->get('description', '');
        if (!empty($desc)) {
            $parts[] = $desc;
        }
        
        // 关键词
        $keywords = $this->get('keywords', []);
        if (!empty($keywords)) {
            $parts[] = '关键词：' . implode('、', $keywords);
        }
        
        // 拼接描述文本
        $text = implode(' - ', $parts);
        
        // 截断到最大长度
        if (mb_strlen($text) > $maxLength) {
            $text = mb_substr($text, 0, $maxLength - 3) . '...';
        }
        
        return $text;
    }
    
    /**
     * 获取完整的元信息数组
     *
     * @return array
     */
    public function getAll() {
        return $this->meta;
    }
    
    /**
     * 输出元信息为 HTML 标签
     *
     * @return string
     */
    public function toHtmlMetaTags() {
        $html = '';
        
        // 站点标题
        $title = $this->get('title', '');
        if (!empty($title)) {
            $html .= '<title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title>' . "\n";
        }
        
        // 描述
        $desc = $this->get('description', '');
        if (!empty($desc)) {
            $html .= '<meta name="description" content="' . htmlspecialchars($desc, ENT_QUOTES, 'UTF-8') . '">' . "\n";
        }
        
        // 关键词
        $keywords = $this->get('keywords', []);
        if (!empty($keywords)) {
            $kwStr = implode(', ', $keywords);
            $html .= '<meta name="keywords" content="' . htmlspecialchars($kwStr, ENT_QUOTES, 'UTF-8') . '">' . "\n";
        }
        
        return $html;
    }
}

// 示例：使用站点元信息
$meta = new SiteMeta([
    'title'       => '开云体育 - 官方网站',
    'description' => '开云体育提供最新体育赛事资讯与娱乐服务，致力于为用户带来专业、安全的在线体验。',
    'keywords'    => ['开云', '体育', '赛事', '娱乐'],
    'url'         => 'https://www.guesstour.com.cn',
]);

// 输出简短描述文本
echo $meta->generateDescription(120) . PHP_EOL;

// 输出 HTML meta 标签
echo $meta->toHtmlMetaTags();