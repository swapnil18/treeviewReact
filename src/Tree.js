
import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class Tree extends React.Component {
 
  treeSign=(data)=> {
    let sign = "";
    console.log(data)
    if(data.name == 'root'){
      sign = <span><a href="javascript:void(0)" onClick={this.addNode.bind(this,data)}>&nbsp;+&nbsp; </a></span>
    } else {
      sign =  <span> 
                <a href="javascript:void(0)" onClick={this.addNode.bind(this,data)}>&nbsp;+&nbsp; </a> 
                <a href="javascript:void(0)" onClick={this.removeNode.bind(this,data)}>&nbsp;-&nbsp; </a> 
              </span>;
    }
    return sign;
  }
  addNode =  function(item) { //add Node function
    let nodeId = item['id'];
    var formdata = new FormData();

    let data = JSON.stringify(item);
    formdata.append( "treedata",data);
    this.sendData(formdata,'addNode');//call add node    
  }
  removeNode= function(item) {
    let nodeId = item['id'];
    let data = JSON.stringify(item);
    var formdata = new FormData();    
    formdata.append( "treedata",data);
    this.sendData(formdata,'removeNode');//call to remove node    
  }
  sendData = function(data,action) { //send data to tree api
    //console.log(data);
    fetch('http://localhost/tree/api/tree.php?action='+action, {
      method: 'POST',
      headers: {
      'Accept': 'application/json',
    },
      body: data
    })
    .then(function(response) {
        this.props.parentCls.fetchTree();
        //console.log(response);
      }.bind(this)
      ).then(function(body) {
        //console.log(body);
      });
  } 
  
  render() {
    const data = this.props.data;
    if (!data) return null;
   
    return (
      <ul>
        {data.map((item,i) => {
           return (
            <li key={item.name+i}>
                {item.name} {this.treeSign(item)}
                  <Tree data={item.children} parentCls = {this.props.parentCls} />
            </li>
            )
        })}
      </ul>
    )
  }
}

export default Tree;