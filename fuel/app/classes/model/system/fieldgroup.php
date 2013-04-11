<?php

    class Model_System_FieldGroup{
        
        static function find($id){
            
            $result = DB::select()->from('object_field_groups')->where('id','=',$id)->execute();
            return current($result->as_array());
            
        }
  
	static function findAllContainers($object_id = 1, $section_id = 0){
            $result = DB::select()
                    ->from('object_field_groups')
                    ->where('object_id', '=', $object_id)
                    ->where('type', '=', 'container')
                    ->order_by('parent_id')
                    ->order_by('sort');
            
            if(!empty($section_id)){
                $result->where('parent_id', '=', $section_id);
            }
            
            $result = $result->execute();
            
            return $result->as_array();
        }
		
	static function findAllSections($object_id = 1){
            $result = DB::select()
                    ->from('object_field_groups')
                    ->where('object_id', '=', $object_id)
                    ->where('type', '=', 'section')
                    ->order_by('sort')
                    ->execute();
            
            return $result->as_array();
        }
        
        static function add($data){
            
            $result = DB::insert('object_field_groups')->set($data)->execute();
            
        }
        
        static function update($id, $data){
            
            $result = DB::update('object_field_groups')->set($data)->where('id', '=', $id)->execute();
            
        }
        
        static function delete($id){
            
            $item = self::find($id);
            
            $container_ids = array($item['id']);
            
            if($item['type'] == 'section'){
                $containers = self::findAllContainers($item['object_id'], $item['id']);
                $container_ids = array();
                foreach($containers as $c){
                    $container_ids[] = $c['id'];
                }
                DB::delete('object_field_groups')->where('id','=', $item['id'])->execute();
            }
            
            if(!empty($container_ids)){
                DB::delete('object_field_groups')->where('id', 'IN', $container_ids)->execute();
                DB::update('object_fields')->set(array('section_id' => 0, 'container_id' => 0))->where('container_id', 'IN', $container_ids)->execute();
            }
            
            
        }
        
        static function resort($sorts){
            
            foreach($sorts as $id => $sort){
                DB::update('object_field_groups')->set(array('sort' => $sort))->where('id','=', $id)->execute();
            }
            
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            return $val;
        }
        
    }