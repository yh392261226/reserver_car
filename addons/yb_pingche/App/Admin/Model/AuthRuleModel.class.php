<?php
namespace Admin\Model;
use Think\Model;
/**
 *规则模型 
 */
class AuthRuleModel extends Model{
    
    public function getdata($where){
        
        $rs=M("auth_rule")->order("nid desc")->where($where)->select();
        return $rs;
    }
    //读取数据时获取分页信息
    /*
     *@参数说明：
     *table是当前读取数据统计的表名
     *where是当前查询的条件
     *order是排序条件
     * @return 数组
     */
    public function pageinfo($table,$where,$order){
        $count=M($table)->where($where)->count();
        $Page=new \Think\Page($count,14);
        $limit=$Page->firstRow.",".$Page->listRows;
        if($order==""){
            $data=M($table)->where($where)->limit($limit)->select();
        }else{
            $data=M($table)->where($where)->limit($limit)->order($order)->select();
        }
        $arr["count"]=$count;
        $arr["page"]=$Page->show();
        $arr["data"]=$data;
        return $arr;
    }
    
    /**
     * @desc删除表中的记录
     * @param参数说明：
     * table:需要操作表名称
     * where:删除操作需要条件
     */
    public function del($table,$where){
        return M($table)->where($where)->delete();
    }
    /**
     * @desc查询表中的记录
     * @param参数说明：
     * table:需要操作表名称
     * where:查询操作需要条件
     */
    
    public function aselect($table,$where){
        return M($table)->where($where)->select();
    }
    /**
     * @desc向表中添加记录
     * @param参数说明：
     * table:需要操作表名称
     * data:需要添加的数据
     */    
    public function aadd($table,$data){
        return M($table)->data($data)->add();
    }
    
    /**
     * @desc修改表中记录
     * @param参数说明：
     * table:需要操作表名称
     * data:需要修改的数据
     * where:需要修改的条件
     */
    public function aupdate($table,$data,$where){
        return M($table)->data($data)->where($where)->save();
    }    
    
    /*
     *@desc 查询表中某一条记录
     *@param参数说明：
     *table:需要操作表名称
     *where:搜索条件 
     */
    public function afind($table,$where){
        return M($table)->where($where)->find();
    }
}