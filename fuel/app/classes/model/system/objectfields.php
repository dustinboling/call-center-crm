<?php

    class Model_System_ObjectFields extends Model{
        
        static function find($id){
            $result = DB::select()->from('object_fields')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll($object_id){
            
            $result = DB::select('f.*', array('ofs.sort', 'section_sort'), array('ofc.sort', 'container_sort'))
                    ->from(array('object_fields','f'))
                    ->join(array('object_field_groups', 'ofc'), 'LEFT')->on('ofc.id','=','f.container_id')
                    ->join(array('object_field_groups', 'ofs'), 'LEFT')->on('ofs.id','=','ofc.parent_id')
                    ->where('f.object_id', '=', $object_id)
                    ->order_by('ofs.sort')
                    ->order_by('ofc.sort')
                    ->order_by('f.sort')
                    ->execute();
            
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
        
        static function findBySectionIDs($section_ids){
            $fields = DB::select()->from('object_fields')->where('section_id', 'in', $section_ids)->order_by('section_id')->order_by('container_id')->order_by('sort')->execute();
            
            $grouped = array();
            foreach($fields->as_array() as $f){
                $grouped[$f['section_id']][$f['container_id']][$f['id']] = $f;
            }
            return $grouped;
        }
        
        static function findAllTypes(){
            $result = DB::select()->from('object_field_types')->execute();
            return $result->as_array();
        }
        
        static function findAllGroups(){
            $result = DB::select()->from('object_field_groups')->execute();
            
            $groups = array();
            foreach($result->as_array() as $row){
                $groups[$row['id']] = $row;
            }
            return $groups;
        }
        
        static function findGroupsByIDs($ids){
            $result = DB::select()->from('object_field_groups')->where('id', 'in', $ids)->execute();
            
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
        
        static function parseTemplate($template, $fields, $additional_fields = array()){
            
            if(!is_array($template)){
                parse_str($template, $template);
            }
            
            foreach($additional_fields as $k => $v){
                $fields[$k] = $v;
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
        
        static function add($data){
            
            $data['clean_name'] = preg_replace('/[^0-9a-z_]/i','', str_replace(' ','_', strtolower($data['name'])));
            
            $result = DB::insert('object_fields')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('object_fields')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('object_fields')->where('id','=',$id)->execute();
        }
           
        static function resort($sorts){
            
            foreach($sorts as $id => $sort){
                DB::update('object_fields')->set(array('sort' => $sort))->where('id','=', $id)->execute();
            }
            
        }
    
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            $val->add('field_type_id', 'Field Type')
                ->add_rule('required');

            return $val;
        }
        
    }