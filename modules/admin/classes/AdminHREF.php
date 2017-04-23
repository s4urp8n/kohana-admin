<?php

defined('SYSPATH') or die('No direct script access.');

class AdminHREF
{
    
    public static $prefixSeparator = '_';
    public static $standartPorts = [
        80,
        8080,
    ];
    
    public static function getDefaultAdminRouteUri($action, $param = null, $primary = null)
    {
        $route = Route::get('adminDefault');
        $uri = '/' . $route->uri(
                [
                    'action'  => $action,
                    'param'   => $param,
                    'primary' => $primary,
                ]
            );
        
        return $uri;
    }
    
    public static function getPort()
    {
        $port = '';
        if (!empty($_SERVER['SERVER_PORT']) && !in_array($_SERVER['SERVER_PORT'], self::$standartPorts))
        {
            $port = $_SERVER['SERVER_PORT'];
        }
        
        return $port;
    }
    
    public static function getSubdomain()
    {
        $host = static::getHost();
        $parts = explode('.', $host);
        $c = count($parts);
        if ($c > 2)
        {
            return implode('.', array_slice($parts, 0, $c - 2));
        }
        
        return false;
    }
    
    public static function getHost()
    {
        if (!empty($_SERVER['HTTP_HOST']))
        {
            return $_SERVER['HTTP_HOST'];
        }
        
        return '';
    }
    
    public static function isActiveHREF($href, $additionalCondition = null)
    {
        
        $additional = false;
        if (!is_null($additionalCondition))
        {
            if ($additionalCondition === true)
            {
                $additional = true;
            }
            if ($additionalCondition === false)
            {
                $additional = false;
            }
        }
        
        $newHref = $href;
        $current = '';
        
        if (self::isAbsoluteHREF($newHref))
        {
            $current = self::getFullCurrentHREF();
            $host = self::getFullHost();
            $hostEquals = mb_substr($newHref, 0, mb_strlen($host)) === $host;
            if ($hostEquals === false)
            {
                return $additional;
            }
            $newHref = mb_substr($newHref, mb_strlen($host));
        }
        
        $current = mb_eregi_replace('^/+', '', self::getPath());
        $currentQuery = self::getQuery();
        if (!empty($currentQuery))
        {
            $current = $current . '?' . http_build_query($currentQuery);
        }
        
        $newHref = mb_eregi_replace('^/+', '', $newHref);
        
        if (empty($current) xor empty($newHref))
        {
            return $additional;
        }
        
        $currentQuery = explode('?', $current);
        $hrefQuery = explode('?', $newHref);
        
        $currentQuery[0] = mb_eregi_replace('^/+|/+$', '', $currentQuery[0]);
        $hrefQuery[0] = mb_eregi_replace('^/+|/+$', '', $hrefQuery[0]);
        
        if (count($currentQuery) == 2 && count($hrefQuery) == 2)
        {
            if ($currentQuery[0] === $hrefQuery[0])
            {
                
                $currentQuery = explode('&', $currentQuery[1]);
                $hrefQuery = explode('&', $hrefQuery[1]);
                
                sort($currentQuery);
                sort($hrefQuery);
                
                if (count($currentQuery) == count($hrefQuery))
                {
                    $intersect = array_intersect($currentQuery, $hrefQuery);
                    if (count($intersect) == count($currentQuery))
                    {
                        return true;
                    }
                }
            }
        }
        elseif (count($currentQuery) == 1 && count($hrefQuery) == 1)
        {
            if (mb_stripos($currentQuery[0], $hrefQuery[0]) === 0)
            {
                return true;
            }
        }
        else
        {
            if ($currentQuery[0] === $hrefQuery[0])
            {
                if (!empty($currentQuery[1]) && empty($hrefQuery[1]))
                {
                    return true;
                }
            }
        }
        
        return $additional;
    }
    
    public static function isAbsoluteHREF($href)
    {
        $str = mb_eregi_replace('\s', '', $href);
        
        return mb_eregi('^http(s)*://', $href);
    }
    
    public static function getFullCurrentHREF(array $unsetQuery = [], array $setQuery = [])
    {
        $query = http_build_query(self::getQuery($unsetQuery, $setQuery));
        $href = self::getFullHost() . self::getPath();
        
        if (!empty($query))
        {
            if (mb_substr($href, -1, 1) == '/')
            {
                $href = $href . '?' . $query;
            }
            else
            {
                $href = $href . '/?' . $query;
            }
        }
        
        return $href;
    }
    
    public static function getFullHost()
    {
        return self::getProtocol() . '://' . self::getHost();
    }
    
    public static function getPath()
    {
        if (!empty($_SERVER['PATH_INFO']))
        {
            return $_SERVER['PATH_INFO'];
        }
        
        return '';
    }
    
    public static function getQuery(array $unset = [], array $set = [])
    {
        $get = [];
        if (!empty($_GET))
        {
            $get = $_GET;
        }
        
        if (!empty($unset))
        {
            foreach ($unset as $value)
            {
                if (isset($get[$value]))
                {
                    unset($get[$value]);
                }
            }
        }
        
        if (!empty($set))
        {
            
            foreach ($set as $key => $value)
            {
                $get[$key] = $value;
            }
        }
        
        return $get;
    }
    
    public static function getProtocol()
    {
        $protocol = '';
        if (!empty($_SERVER['SERVER_PROTOCOL']))
        {
            $protocol = mb_substr($_SERVER['SERVER_PROTOCOL'], 0, mb_strpos($_SERVER['SERVER_PROTOCOL'], '/'));
        }
        
        return mb_convert_case($protocol, MB_CASE_LOWER);
    }
    
    public static function getNoFilterParamsHREF()
    {
        $prefix = Admin::getConfig('filterQueryPrefix');
        $prefix .= self::$prefixSeparator;
        $filterParams = array_keys(self::getFilterParams());
        foreach ($filterParams as $key => $value)
        {
            $filterParams[$key] = $prefix . $value;
        }
        $filterParams = array_merge($filterParams, [Admin::getConfig('pageQueryParam')]);
        
        return self::getFullCurrentHREF($filterParams);
    }
    
    public static function getFilterParams()
    {
        $prefix = Admin::getConfig('filterQueryPrefix');
        $params = [];
        if (!empty($_GET))
        {
            $regs = [];
            foreach ($_GET as $key => $value)
            {
                if (mb_eregi('^' . $prefix . self::$prefixSeparator . '(\w+)', $key, $regs))
                {
                    $params[$regs[1]] = $value;
                }
            }
        }
        
        return $params;
    }
    
    public static function getPage()
    {
        $getParam = Admin::getConfig('pageQueryParam');
        if (!empty($_GET[$getParam]) && is_numeric($_GET[$getParam]) && $_GET[$getParam] >= 1)
        {
            return $_GET[$getParam];
        }
        
        return 1;
    }
    
    public static function getSearchString()
    {
        $getParam = Admin::getConfig('searchQueryParam');
        if (!empty($_GET[$getParam]))
        {
            $string = mb_eregi_replace('\s+', ' ', $_GET[$getParam]);
            $string = mb_eregi_replace('\s+$', '', $string);
            $string = mb_eregi_replace('^\s+', '', $string);
            $string = mb_eregi_replace('^\s+', '', $string);
            $string = mb_eregi_replace('[^\d_\. ,:\-\(\)\+\w]+', '', $string);
            if (!empty($string))
            {
                return $string;
            }
        }
        
        return '';
    }
    
}
