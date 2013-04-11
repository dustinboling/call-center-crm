<?php   

    class Model_System_Campaign extends Model{
        
        static function find($id){
            $result = DB::select()->from('campaigns')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select()->from('campaigns')->execute();
            return $result->as_array();
            
        }
        
        static function findByName($name){
            $result = DB::select()->from('campaigns')->where('name', '=', $name)->execute();
            if(count($result)){
                return current($result->as_array());
            }else{
                return array();
            }
        }
        
        static function add($data){
            
            $groups = array();
            if(isset($data['groups'])){
                $groups = $data['groups'];
                unset($data['groups']);
            }
            
            $result = DB::insert('campaigns')->set($data)->execute();
            Model_System_DistributionCampaign::set($result[0], $groups);
            
            return current($result);
        }
        
        static function update($id, $data){
            
            $groups = array();
            if(isset($data['groups'])){
                $groups = $data['groups'];
                unset($data['groups']);
            }
            
            $result = DB::update('campaigns')->set($data)->where('id', '=', $id)->execute();
            Model_System_DistributionCampaign::set($id, $groups);
        }
        
        static function delete($id){
            $result = DB::delete('campaigns')->where('id','=',$id)->execute();
            Model_System_DistributionCampaign::delete($id);
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            return $val;
        }
        
    }