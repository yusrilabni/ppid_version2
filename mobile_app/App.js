import React, { useEffect, useState } from 'react';
import { StyleSheet, Text, View, FlatList, Image, SafeAreaView, ActivityIndicator, StatusBar } from 'react-native';
import { API_ENDPOINTS } from './src/api/config';

export default function App() {
  const [loading, setLoading] = useState(true);
  const [officials, setOfficials] = useState([]);

  useEffect(() => {
    fetchOfficials();
  }, []);

  const fetchOfficials = async () => {
    try {
      const response = await fetch(API_ENDPOINTS.OFFICIALS);
      const json = await response.json();
      if (json.success) {
        setOfficials(json.data);
      }
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
    }
  };

  const renderItem = ({ item }) => (
    <View style={styles.card}>
      <Image 
        source={{ uri: item.photo ? `https://ppidkab.sinjaikab.go.id/v2/storage/${item.photo}` : 'https://via.placeholder.com/150' }} 
        style={styles.avatar} 
      />
      <View style={styles.info}>
        <Text style={styles.name}>{item.full_name}</Text>
        <Text style={styles.position}>{item.position?.name || 'Pimpinan'}</Text>
        <Text style={styles.org}>{item.organization?.name}</Text>
      </View>
    </View>
  );

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="dark-content" />
      <View style={styles.header}>
        <Text style={styles.headerTitle}>PPID SINJAI</Text>
        <Text style={styles.headerSubtitle}>Daftar Pimpinan & Pejabat</Text>
      </View>

      {loading ? (
        <View style={styles.center}>
          <ActivityIndicator size="large" color="#2563eb" />
          <Text style={styles.loadingText}>Memuat Metadata...</Text>
        </View>
      ) : (
        <FlatList
          data={officials}
          renderItem={renderItem}
          keyExtractor={item => item.id.toString()}
          contentContainerStyle={styles.list}
        />
      )}
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f8fafc',
  },
  header: {
    padding: 20,
    backgroundColor: '#ffffff',
    borderBottomWidth: 1,
    borderBottomColor: '#e2e8f0',
    alignItems: 'center',
  },
  headerTitle: {
    fontSize: 24,
    fontWeight: '900',
    color: '#1e293b',
    letterSpacing: 1,
  },
  headerSubtitle: {
    fontSize: 12,
    color: '#64748b',
    textTransform: 'uppercase',
    fontWeight: 'bold',
    marginTop: 4,
  },
  list: {
    padding: 15,
  },
  card: {
    backgroundColor: '#ffffff',
    borderRadius: 20,
    padding: 15,
    marginBottom: 15,
    flexDirection: 'row',
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.05,
    shadowRadius: 10,
    elevation: 3,
  },
  avatar: {
    width: 70,
    height: 70,
    borderRadius: 35,
    backgroundColor: '#f1f5f9',
  },
  info: {
    marginLeft: 15,
    flex: 1,
  },
  name: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#1e293b',
  },
  position: {
    fontSize: 13,
    color: '#2563eb',
    fontWeight: '600',
    marginTop: 2,
  },
  org: {
    fontSize: 11,
    color: '#64748b',
    marginTop: 4,
  },
  center: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  loadingText: {
    marginTop: 10,
    color: '#64748b',
    fontSize: 12,
  }
});
