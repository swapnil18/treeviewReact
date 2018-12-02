<?php
require_once("functions.php");
header('Access-Control-Allow-Origin: *');

class Tree extends functions {
	function __constructor() {		
	}

	function list() {
		$parent_id = 0;
		$treeData = $this->getTreeData($parent_id);
		return $this->response($treeData);
	}

	function addNode() {
		$postData = json_decode($_POST['treedata']);
		$parent_id = $postData->id;

		$data = ['name'=>'node','parent_id'=>$parent_id];
		$treeData = $this->addTreeNode($data);
		return $this->response($treeData);
	}

	function removeNode() {
		$postData = json_decode($_POST['treedata']);
		$parent_id = $postData->id;
		$treeData = $this->removeTreeNode($parent_id);
		return $this->response($treeData);
	}
}

$action = $_REQUEST['action'];

$tree = new Tree();
echo $tree->$action();


?>