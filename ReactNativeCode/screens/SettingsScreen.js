/********************************************************************/
/*  Author:     Stephen Magrowski                                   */
/*  Created:    Febuary 1, 2020                                     */
/*  Course:     CSC 355-020                                         */
/*  Professor:  Dr. Tan                                             */
/*  Filename:   SettingsScreen.js                                   */
/*  Purpose:    This file contains the user options for either      */
/*              logging out of an account or updating account       */
/*              information.                                        */
/*                                                                  */
/********************************************************************/

import React, { Component } from 'react';
import { Dimensions } from 'react-native';
import { StyleSheet, Text, View, TouchableOpacity } from 'react-native';

export default class SettingsScreen extends Component {
  static navigationOptions = ({
    title: 'Settings'   // displayed at top of screen
 });

 LogOut = () => {
  // Networking for sending user inputs to PHP server
    fetch('http://csitrd.kutztown.edu/~smagr173/backend/log_out.php', {
    method:'POST',
    header:{
      'Accept': 'application/json',
      'Content-type': 'application/json'
    }
    
  })
  .then((response) => response.json())
   .then((responseJson)=>{
     if(responseJson == 0){
       
       // redirect to profile page
       const {navigate} = this.props.navigation;
    navigate('Initial')
     }else{
 
      console.warn(responseJson);  // gets displayed as console msg
     }
   })
   .catch((error)=>{
   console.error(error);
   });
  
}
  render() {
    const {navigate} = this.props.navigation;
      return (
        <View style={styles.container}>

        <TouchableOpacity
 	    	 onPress={() => navigate('Update')}
        style={{marginTop:20,width: Dimensions.get('window').width*.55,height:Dimensions.get('window').height*.065,
        padding:10, justifyContent:'center',backgroundColor:'black',alignItems:'center'}}>
  	  	<Text style={styles.buttonText}>Update Info</Text>
  	  	</TouchableOpacity> 

        <Text style={styles.divider}>_______________________________________</Text>

        <TouchableOpacity
        onPress={this.LogOut}
        style={{marginTop:20,width: Dimensions.get('window').width*.55,height:Dimensions.get('window').height*.065,padding:10,
        justifyContent:'center',backgroundColor:'black', alignItems:'center'}}>
  	  	<Text style={styles.buttonText}>Log Out</Text>
  	  	</TouchableOpacity>  

         </View>
      
       );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: 'white'
  },
  pageText: {
    margin:10,
    fontWeight:'bold',
    color:'gray',
    textAlign:'center',
    fontSize:12
  },
  buttonText: {
		fontWeight:'bold',
		color:'white',
		textAlign:'center',
		fontSize:Dimensions.get('window').height*.023,
	  },
  link: {
    width:100,
    padding:10,
    alignItems:'center'
  },
  divider: {
    color:'black',
    textAlign:'center',
    fontSize:Dimensions.get('window').height*.025,
  }
  
  });