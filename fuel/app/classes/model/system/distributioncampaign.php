<?php

    class Model_System_DistributionCampaign extends Model{
        
        static function set($campaign_id, $groups){
            
            $result = DB::select()->from('distribution_groups_campaigns')->where('campaign_id','=',$campaign_id)->execute();

            if(count($result) && !empty($groups)){
                $remove = array();
                foreach($result->as_array() as $r){
                    $match = array_search($r['group_id'], $groups);

                    if($match !== false){
                        unset($groups[$match]);
                    }else{
                        $remove[] = $r['group_id'];
                    }
                }
                
            }else if(count($result) && empty($groups)){
                DB::delete('distribution_groups_campaigns')->where('campaign_id','=',$campaign_id)->execute();
                return;
            }
            
            if(!empty($groups)){
                foreach($groups as $g){
                    DB::insert('distribution_groups_campaigns')->set(array('group_id' => $g, 'campaign_id' => $campaign_id))->execute();
                }
            }
            
            if(!empty($remove)){
                DB::delete('distribution_groups_campaigns')->where('campaign_id','=',$campaign_id)->where('group_id','in',$remove)->execute();
            }
            
        }
        
        static function findByCampaign($id){
            $result = DB::select()->from('distribution_groups_campaigns')->where('campaign_id','=',$id)->execute();
            return $result->as_array();
        }
        
        static function delete($campaign_id){
            DB::delete('distribution_groups_campaigns')->where('campaign_id','=',$campaign_id)->execute();
        }
        
    }