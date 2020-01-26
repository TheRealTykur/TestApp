import React, { Component } from 'react';
import { SectionList, StyleSheet, Text, View } from 'react-native';

export default class MenuScreen extends Component {
  render() {
    return (
      <View style={styles.container}>
        <SectionList
          sections={[
            {title: 'Burgers', data: ['Bacon Bleu', 'Chesseburger']},
            {title: 'Fries', data: ['Nacho Jalepeno', 'Old Bay', 'Nacho']},
          ]}
          renderItem={({item}) => <Text style={styles.item}>{item}</Text>}
          renderSectionHeader={({section}) => <Text style={styles.sectionHeader}>
          {section.title}</Text>}
          keyExtractor={(item, index) => index}
          />
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
  },
  sectionHeader: {  /** For Category Header */
    paddingTop: 2,
    paddingLeft: 10,
    paddingRight: 10,
    paddingBottom: 2,
    fontSize: 18,
    fontWeight: 'bold',
  },
  item: {   /** For each item in list */
    padding: 10,
    fontSize: 14,
    height: 44,
  },
  })

MenuScreen.navigationOptions = {
  title: 'Menu',   /** Title Top of Page */
};
