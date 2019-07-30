<?php
namespace app\month\controller;

use think\Controller;
use app\month\model\Student;
use app\month\model\Vehi;
use app\month\model\Make;
class Index extends Controller
{
    public function index()
    {	//查询班车信息
    	$data = Vehi::all();
        return view('index',['data'=>$data]);
    }
    //添加
    public function add()
    {
    	$data = input(); //接值
    	// print_r($data);
    	$user = new Make();
    	$user->save($data); //入库
    	if($user){
    		echo json_encode(['code'=>200,'msg'=>1]);
    	}else{
    		echo json_encode(['code'=>201,'msg'=>2]);
    	}
    }
    //展示页
    public function show()
    {	
    	//当前页
    	$page = input('page',1);
    	$ajax = input('ajax');
    	//数据总条数
    	$count = Make::all();
    	$count = count($count);
    	// print_r($count);
    	//每页显示条数
    	$pagesize = 3;
    	//总页数
    	$last = ceil($count/$pagesize);
    	//上一页
    	$up = ($page>1)?$page-1:$page;
    	//下一页
    	$down = ($page<$last)?$page+1:$last;
    	//偏移量
    	$offset = ($page-1)*$pagesize;
    	$data = Make::limit($offset,$pagesize)->select();
    	if($ajax){
    		echo json_encode([
    			'code'=>200,
    			'msg'=>$data,
    			'last'=>$last,
    			'page'=>$page,
    			'up'=>$up,
    			'down'=>$down
    		]);
    	}else{
    		return view('show',[
    			'data'=>$data,
    			'last'=>$last,
    			'page'=>$page,
    			'up'=>$up,
    			'down'=>$down
    		]);
    	}
    	
    }
    //详情
    public function look()
    {	//接ID
    	$id = input('id');
    	// print_r($id);
    	//根据ID查询数据
    	$data = Make::where('id',$id)->select();
    	// print_r($data);
    	return view('look',['data'=>$data]);
    }
    //删除
    public function del()
    {
    	//接ID
    	$id = input('id');
    	//根据id删除数据
    	$data = Make::where('id',$id)->delete();
    	if($data){
    		echo json_encode(['code'=>200,'msg'=>1]);
    	}else{
    		echo json_encode(['code'=>201,'msg'=>2]);
    	}
    }
}
