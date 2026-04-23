import React, { useState, useEffect } from 'react';
import { StyleSheet, Text, View, StatusBar, Image, TouchableOpacity, FlatList, ActivityIndicator, RefreshControl } from 'react-native';
import { Accessibility, Users, MapPin, Briefcase } from 'lucide-react-native';
import { API_ENDPOINTS } from '../api/config';

const STATUSBAR_HEIGHT = StatusBar.currentHeight || 0;

export default function PejabatScreen() {
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const [officials, setOfficials] = useState([]);
  const [error, setError] = useState(null);

  const fetchOfficials = async () => {
    try {
      setLoading(true);
      const response = await fetch(API_ENDPOINTS.OFFICIALS);
      const result = await response.json();
      
      if (result.success) {
        setOfficials(result.data);
        setError(null);
      } else {
        setError('Gagal memuat data pimpinan');
      }
    } catch (err) {
      setError('Terjadi kesalahan koneksi');
      console.error(err);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  useEffect(() => {
    fetchOfficials();
  }, []);

  const onRefresh = () => {
    setRefreshing(true);
    fetchOfficials();
  };

  const renderOfficialItem = ({ item }) => (
    <View style={styles.card}>
      <View style={styles.cardHeader}>
        <View style={styles.avatarContainer}>
            {item.photo ? (
                <Image source={{ uri: `https://ppidkab.sinjaikab.go.id/storage/${item.photo}` }} style={styles.avatar} />
            ) : (
                <View style={[styles.avatar, styles.avatarPlaceholder]}>
                    <Users size={24} color="#94a3b8" />
                </View>
            )}
        </View>
        <View style={styles.infoWrapper}>
          <Text style={styles.officialName}>{item.full_name}</Text>
          <View style={styles.row}>
            <Briefcase size={12} color="#64748b" style={styles.icon} />
            <Text style={styles.jobText}>{item.position?.name || 'Jabatan tidak tersedia'}</Text>
          </View>
          <View style={styles.row}>
            <MapPin size={12} color="#64748b" style={styles.icon} />
            <Text style={styles.orgText}>{item.organization?.name || 'Unit Kerja'}</Text>
          </View>
        </View>
      </View>
    </View>
  );

  return (
    <View style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="transparent" translucent={true} />

      <View style={[styles.headerContainer, { paddingTop: STATUSBAR_HEIGHT + 10 }]}>
          <View style={styles.headerContent}>
            <Image source={require('../../assets/logo_ppid.webp')} style={styles.headerLogo} resizeMode="contain" />
            <View style={styles.headerTextWrapper}>
              <Text style={styles.welcomeLabel}>Pengelola Informasi</Text>
              <Text style={styles.brandLabel}>Struktur Pejabat</Text>
            </View>
            <TouchableOpacity style={styles.headerActionBtn}>
                <Accessibility size={24} color="#2563eb" strokeWidth={2.5} />
            </TouchableOpacity>
          </View>
      </View>

      {loading && !refreshing ? (
        <View style={styles.centerContent}>
          <ActivityIndicator size="large" color="#2563eb" />
          <Text style={styles.loadingText}>Menghubungkan ke server...</Text>
        </View>
      ) : error ? (
        <View style={styles.centerContent}>
          <Text style={styles.errorText}>{error}</Text>
          <TouchableOpacity style={styles.retryBtn} onPress={fetchOfficials}>
            <Text style={styles.retryText}>Coba Lagi</Text>
          </TouchableOpacity>
        </View>
      ) : (
        <FlatList
          data={officials}
          keyExtractor={(item) => item.id.toString()}
          renderItem={renderOfficialItem}
          contentContainerStyle={styles.listContainer}
          refreshControl={
            <RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={['#2563eb']} />
          }
          ListEmptyComponent={
            <View style={styles.centerContent}>
              <Users size={48} color="#cbd5e1" strokeWidth={1} />
              <Text style={styles.emptyText}>Tidak ada data pimpinan</Text>
            </View>
          }
        />
      )}
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f8fafc' },
  headerContainer: { backgroundColor: '#fff', borderBottomWidth: 1, borderBottomColor: '#f1f5f9', elevation: 8, shadowColor: '#000', shadowOpacity: 0.05, shadowRadius: 10, zIndex: 100 },
  headerContent: { paddingHorizontal: 20, paddingBottom: 15, flexDirection: 'row', alignItems: 'center' },      
  headerLogo: { width: 45, height: 45, marginRight: 15 },
  headerTextWrapper: { flex: 1 },
  welcomeLabel: { fontSize: 10, color: '#94a3b8', fontWeight: '900', textTransform: 'uppercase' },
  brandLabel: { fontSize: 19, fontWeight: '900', color: '#1e293b' },
  headerActionBtn: { width: 44, height: 44, borderRadius: 15, backgroundColor: '#f8fafc', justifyContent: 'center', alignItems: 'center', borderWidth: 1, borderColor: '#eff6ff' },
  
  listContainer: { padding: 15, paddingBottom: 100 },
  card: { backgroundColor: '#fff', borderRadius: 20, padding: 15, marginBottom: 15, elevation: 4, shadowColor: '#000', shadowOpacity: 0.05, shadowRadius: 10, borderWidth: 1, borderColor: '#f1f5f9' },
  cardHeader: { flexDirection: 'row', alignItems: 'center' },
  avatarContainer: { width: 60, height: 60, borderRadius: 15, overflow: 'hidden', backgroundColor: '#f1f5f9' },
  avatar: { width: '100%', height: '100%' },
  avatarPlaceholder: { justifyContent: 'center', alignItems: 'center' },
  infoWrapper: { flex: 1, marginLeft: 15 },
  officialName: { fontSize: 15, fontWeight: '900', color: '#1e293b', marginBottom: 4 },
  row: { flexDirection: 'row', alignItems: 'center', marginTop: 2 },
  icon: { marginRight: 6 },
  jobText: { fontSize: 12, color: '#64748b', fontWeight: '600' },
  orgText: { fontSize: 11, color: '#94a3b8', fontWeight: '500' },

  centerContent: { flex: 1, justifyContent: 'center', alignItems: 'center', padding: 40 },
  loadingText: { marginTop: 15, fontSize: 12, color: '#64748b', fontWeight: '700' },
  errorText: { fontSize: 14, color: '#ef4444', fontWeight: '700', textAlign: 'center' },
  retryBtn: { marginTop: 15, paddingHorizontal: 20, paddingVertical: 10, backgroundColor: '#2563eb', borderRadius: 10 },
  retryText: { color: '#fff', fontWeight: '800' },
  emptyText: { marginTop: 15, color: '#94a3b8', fontWeight: '800', fontSize: 12, textTransform: 'uppercase' }
});
