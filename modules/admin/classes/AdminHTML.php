<?php

defined('SYSPATH') or die('No direct script access.');

class AdminHTML extends HTML
{
    
    public static function renderNoneFound()
    {
        return self::renderMessage('Ничего не найдено :-(');
    }
    
    public static function renderMessage($message, $messageType = 'warning', $heading = null)
    {
        $attrs = [
            'class' => [
                'alert',
                'alert-' . $messageType,
            ],
        ];
        
        $content = '';
        if (!empty($heading))
        {
            $content = self::renderPairTag('strong', $heading) . ' ' . '<br/>' . $message;
        }
        else
        {
            $content = $message;
        }
        
        return self::renderPairTag('div', $content, $attrs);
    }
    
    public static function renderPairTag($tag, $content, array $attrs = [])
    {
        return "<" . $tag . self::renderAttrs($attrs) . ">" . $content . "</" . $tag . ">";
    }
    
    public static function renderAttrs(array $attrs)
    {
        $render = '';
        foreach ($attrs as $name => $value)
        {
            if (is_array($value))
            {
                $render .= ' ' . $name . '="' . implode(' ', $value) . '"';
            }
            else
            {
                $render .= ' ' . $name . '="' . $value . '"';
            }
        }
        
        return $render . ' ';
    }
    
    public static function renderRestriction()
    {
        return AdminHTML::renderMessage('Доступ ограничен. Отсутствуют необходимые права.');
    }
    
    public static function renderField($fieldName, $fieldInfo, $currentValue = null, array $attrs = [])
    {
        switch ($fieldInfo['type'])
        {
            case 'number':
            {
                $attrs['type'] = 'number';
                
                return Form::input($fieldName, $currentValue, $attrs);
            }
            case 'caption':
            {
                return $currentValue;
            }
            case 'text':
            {
                return Form::input($fieldName, $currentValue, $attrs);
            }
            case 'time':
            {
                $attrs['type'] = 'time';
                
                return Form::input($fieldName, $currentValue, $attrs);
            }
            case 'password':
            {
                $attrs['type'] = 'password';
                $attrs['placeholder'] = 'Введите пароль перед сохранением';
                
                return Form::input($fieldName, '', $attrs);
            }
            case 'email':
            {
                $attrs['type'] = 'email';
                
                return Form::input($fieldName, $currentValue, $attrs);
            }
            case 'textarea':
            {
                return Form::textarea($fieldName, $currentValue, $attrs);
            }
            case 'editor':
            {
                if (isset($attrs['class']))
                {
                    $attrs['class'] .= ' editor';
                }
                else
                {
                    $attrs['class'] = 'editor';
                }
                
                return Form::textarea($fieldName, $currentValue, $attrs);
            }
            case 'youtube':
            {
                if (isset($attrs['class']))
                {
                    $attrs['class'] .= ' youtube';
                }
                else
                {
                    $attrs['class'] = 'youtube';
                }
                
                return Form::textarea($fieldName, $currentValue, $attrs);
            }
            case 'color':
            {
                if (isset($attrs['class']))
                {
                    $attrs['class'] .= ' color';
                }
                else
                {
                    $attrs['class'] = 'color';
                }
                
                return Form::input($fieldName, $currentValue, $attrs);
            }
            case 'coords':
            {
                if (isset($attrs['class']))
                {
                    $attrs['class'] .= ' yandexmap';
                }
                else
                {
                    $attrs['class'] = 'yandexmap';
                }
                
                return View::factory(
                    'Admin/Fields/YandexMap', [
                                                'fieldName'    => $fieldName,
                                                'currentValue' => $currentValue,
                                                'attrs'        => $attrs,
                                            ]
                );
            }
            case 'date':
            {
                if (isset($attrs['class']))
                {
                    $attrs['class'] .= ' date';
                }
                else
                {
                    $attrs['class'] = 'date';
                }
                
                return Form::input($fieldName, $currentValue, $attrs);
            }
            case 'bool':
            {
                $id = md5(uniqid('', true));
                
                return '<div class="switch">' . Form::radio($fieldName, 1, !empty($currentValue), ['id' => $id])
                       . '<label for="' . $id . '">Да</label>' . Form::radio(
                    $fieldName, 0, empty($currentValue), ['id' => $id . '_2']
                ) . '<label for="' . $id . '_2">Нет</label>' . '</div>';
            }
            case 'select':
            {
                if (!empty($fieldInfo['options']))
                {
                    return Form::select($fieldName, $fieldInfo['options'], $currentValue, $attrs);
                }
            }
            case 'multiselect':
            {
                if (!empty($fieldInfo['options']))
                {
                    $attrs['multiple'] = 'multiple';
                    $attrs['size'] = count($fieldInfo['options']);
                    
                    if ($attrs['size'] > 10)
                    {
                        $attrs['size'] = 10;
                    }
                    
                    return Form::select($fieldName, $fieldInfo['options'], $currentValue, $attrs);
                }
            }
            case 'tags':
            {
                if (isset($attrs['class']))
                {
                    $attrs['class'] .= ' tagsInput';
                }
                else
                {
                    $attrs['class'] = 'tagsInput';
                }
                
                return Form::input($fieldName, $currentValue, $attrs);
            }
            case 'imagepicker':
            {
                if (!empty($fieldInfo['options']) && !empty($fieldInfo['getImage'])
                    && is_callable(
                        $fieldInfo['getImage']
                    )
                )
                {
                    $attrs['multiple'] = 'multiple';
                    $attrs['size'] = count($fieldInfo['options']);
                    if (isset($attrs['class']))
                    {
                        $attrs['class'] .= ' image-picker';
                    }
                    else
                    {
                        $attrs['class'] = 'image-picker';
                    }
                    
                    return Form::select(
                        $fieldName, $fieldInfo['options'], $currentValue, $attrs, $fieldInfo['getImage']
                    );
                }
            }
        }
        
        return false;
    }
    
    public static function renderTag($tag, array $attrs = [])
    {
        return "<" . $tag . ' ' . self::renderAttrs($attrs) . " />";
    }
    
}
