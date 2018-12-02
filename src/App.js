import React, { Component } from 'react';
import Tree from './Tree';
import './App.css'; 

class App extends Component {
  constructor(props) {
    super(props);
    this.state = {
      error: null,
      isLoaded: false,
      items: []
    };
  }

  fetchTree= function() { //fetch tree list
       fetch("http://localhost/tree/api/tree.php?action=list",{      
         headers: {
        },
      })
      .then(res => res.json())
      .then(
        (result) => {
          //console.log(result);
          this.setState({
            isLoaded: true,
            items: result
          });
        },
       (error) => {
          //console.log(error);
          this.setState({
            isLoaded: true,
            error
          });
        }
      )
  }
  componentDidMount() { //load tree 
    this.fetchTree();
  }

  render() {
    const dataSource = this.state.items;
    if (!dataSource) return null;
    return (
      <Tree data={dataSource} parentCls={this}/>
    )
  }
}

export default App;
