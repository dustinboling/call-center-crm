<?php

    class Model_System_ObjectFields extends Model{
        
        static function findAll($object_id){
            $result = DB::select()->from('object_fields')->where('object_id', '=', $object_id)->order_by('section_id')->order_by('container_id')->order_by('sort')->execute();
            return $result->as_array();
        }
        
        static function findAllGrouped($object_id){
            $fields = self::findAll($object_id);
            $grouped = array();
            foreach($fields as $f){
                $grouped[$f['section_id']][$f['container_id']][$f['id']] = $f;
            }
            return $grouped;
        }
        
        static function findAllGroups(){
            $result = DB::select()->from('object_field_groups')->execute();
            
            $groups = array();
            foreach($result->as_array() as $row){
                $groups[$row['id']] = $row;
            }
            return $groups;
        }
        
        static function findByType($object_id, $type_id){
            $result = DB::select()->from('object_fields')->where('object_id', '=', $object_id)->where('field_type_id','=',$type_id)->execute();
            return $result->as_array();
        }
        
        static function findFeeFields($object_id){
            $result = DB::select()->from('object_fields')->where('object_id', '=', $object_id)->where('fee','=',1)->execute();
            return $result->as_array();
        }
        
        static function parseTemplate($template, $fields){
            
            if(!is_array($template)){
                parse_str($template, $template);
            }
            
            foreach($template as $k => $v){
                if(preg_match_all('/{[^}]+}/', $v, $matches)){
                    foreach($matches[0] as $match){
                        $path = str_replace(array('{','}'),'', $match);
                        $template[$k] = str_replace($match, $fields[$path], $template[$k]);
                    }
                }
            }
            
            return $template;
        }
        
        static function findAllOptions($object_id){
            
            $result = DB::select('ofo.*')->from(array('object_field_options','ofo'))
                    ->join(array('object_fields', 'of'))->on('of.id', '=', 'ofo.object_field_id')
                    ->where('of.object_id', '=', $object_id)
                    ->order_by('ofo.object_field_id')
                    ->order_by('ofo.sort')
                    ->execute();
            
            $options = array();
            foreach($result->as_array() as $row){
                $options[$row['object_field_id']][$row['id']] = $row['value'];
            }
            
            return $options;
            
        }
        
        
    }