import React, { useState, useEffect, useCallback } from 'react';
import { StyleSheet, Text, View, StatusBar, Image, TouchableOpacity, FlatList, ActivityIndicator, RefreshControl, TextInput, ScrollView } from 'react-native';
import { Accessibility, FileText, Calendar, Building, ChevronRight, ChevronLeft, Archive, CheckCircle2, Search, X, Clock } from 'lucide-react-native';
import { LinearGradient } from 'expo-linear-gradient';
import { API_ENDPOINTS } from '../api/config';

const STATUSBAR_HEIGHT = StatusBar.currentHeight || 0;

export default function InformasiScreen() {
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const [documents, setDocuments] = useState([]);
  const [error, setError] = useState(null);
  
  const [searchQuery, setSearchQuery] = useState('');
  const [selectedStatus, setSelectedStatus] = useState('Semua');
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [totalData, setTotalData] = useState(0);

  const fetchDocuments = useCallback(async (page = 1, query = '', status = 'Semua') => {
    try {
      setLoading(true);
      let url = `${API_ENDPOINTS.INFORMASI}?page=${page}&per_page=10`;
      if (query) url += `&q=${encodeURIComponent(query)}`;
      if (status !== 'Semua') url += `&status=${status}`;

      const response = await fetch(url);
      const result = await response.json();
      
      if (result.success) {
        setDocuments(result.data.data || []);
        setCurrentPage(result.data.current_page);
        setLastPage(result.data.last_page);
        setTotalData(result.data.total);
        setError(null);
      } else {
        setError('Gagal memuat daftar dokumen');
      }
    } catch (err) {
      setError('Gagal menghubungkan ke server');
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  }, []);

  useEffect(() => {
    const delayDebounceFn = setTimeout(() => {
      setCurrentPage(1);
      fetchDocuments(1, searchQuery, selectedStatus);
    }, 500);
    return () => clearTimeout(delayDebounceFn);
  }, [searchQuery, selectedStatus]);

  const onRefresh = () => {
    setRefreshing(true);
    fetchDocuments(1, searchQuery, selectedStatus);
  };

  const renderDocumentItem = ({ item }) => {
    const isArsip = item.status === 'ARSIP';
    
    return (
      <TouchableOpacity style={styles.cardWrapper} activeOpacity={0.9}>
        {/* Dekorasi Garis Status */}
        <View style={[styles.statusStrip, isArsip ? styles.stripArsip : styles.stripBerlaku]} />
        
        <View style={[styles.cardContainer, isArsip && styles.cardArsipBg]}>
          <View style={styles.cardTop}>
            <View style={[styles.iconContainer, isArsip ? styles.iconArsipBg : styles.iconBerlakuBg]}>
                {isArsip ? <Archive size={20} color="#94a3b8" /> : <FileText size={20} color="#2563eb" />}
            </View>
            <View style={styles.headerInfo}>
                <Text style={[styles.categoryTxt, isArsip && styles.txtArsipSub]}>{item.category || 'DOKUMEN PUBLIK'}</Text>
                <View style={[styles.badge, isArsip ? styles.badgeArsip : styles.badgeBerlaku]}>
                    <Text style={[styles.badgeTxt, isArsip ? styles.badgeTxtArsip : styles.badgeTxtBerlaku]}>
                        {item.status}
                    </Text>
                </View>
            </View>
          </View>

          <Text style={[styles.titleTxt, isArsip && styles.txtArsipMain]} numberOfLines={2}>
            {item.title}
          </Text>

          <View style={styles.divider} />

          <View style={styles.cardBottom}>
            <View style={styles.metaGroup}>
                <View style={styles.metaItem}>
                    <Clock size={12} color="#94a3b8" />
                    <Text style={styles.metaTxt}>{item.tanggal_upload || 'Terbaru'}</Text>
                </View>
                <View style={[styles.metaItem, { flex: 1 }]}>
                    <Building size={12} color="#94a3b8" />
                    <Text style={styles.metaTxt} numberOfLines={1} ellipsizeMode="trailing">
                        {item.organization_name}
                    </Text>
                </View>
            </View>
            <View style={styles.actionBtn}>
                <ChevronRight size={16} color="#2563eb" strokeWidth={3} />
            </View>
          </View>
        </View>
      </TouchableOpacity>
    );
  };

  return (
    <View style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="transparent" translucent={true} />

      {/* HEADER PREMIUM */}
      <View style={[styles.headerSection, { paddingTop: STATUSBAR_HEIGHT + 10 }]}>
          <View style={styles.headerTop}>
            <View style={styles.logoCircle}>
                <Image source={require('../../assets/icon.webp')} style={styles.logo} resizeMode="contain" />
            </View>
            <View style={styles.headerTxtWrapper}>
              <Text style={styles.subTitle}>SISTEM INFORMASI DATA</Text>
              <Text style={styles.mainTitle}>Dokumen Publik</Text>
            </View>
            <View style={styles.countBadge}>
                <Text style={styles.countTxt}>{totalData}</Text>
            </View>
          </View>

          <View style={styles.searchRow}>
            <View style={styles.searchContainer}>
                <Search size={18} color="#94a3b8" />
                <TextInput 
                    style={styles.searchInput}
                    placeholder="Cari kata kunci..."
                    placeholderTextColor="#94a3b8"
                    value={searchQuery}
                    onChangeText={setSearchQuery}
                />
                {searchQuery.length > 0 && (
                    <TouchableOpacity onPress={() => setSearchQuery('')}>
                        <X size={18} color="#94a3b8" />
                    </TouchableOpacity>
                )}
            </View>
          </View>

          <ScrollView horizontal showsHorizontalScrollIndicator={false} style={styles.filterScroll}>
            {['Semua', 'BERLAKU', 'ARSIP'].map((status) => (
                <TouchableOpacity 
                    key={status}
                    onPress={() => setSelectedStatus(status)}
                    style={[styles.filterTab, selectedStatus === status && styles.filterTabActive]}
                >
                    <Text style={[styles.filterLabel, selectedStatus === status && styles.filterLabelActive]}>
                        {status}
                    </Text>
                </TouchableOpacity>
            ))}
          </ScrollView>
      </View>

      {loading && !refreshing && documents.length === 0 ? (
        <View style={styles.center}>
          <ActivityIndicator size="large" color="#2563eb" />
          <Text style={styles.loadingTxt}>Menyelaraskan data...</Text>
        </View>
      ) : (
        <FlatList
          data={documents}
          keyExtractor={(item) => item.id.toString()}
          renderItem={renderDocumentItem}
          contentContainerStyle={styles.list}
          refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={['#2563eb']} />}
          ListEmptyComponent={
            <View style={styles.center}>
              <Image source={require('../../assets/logo_ppid.webp')} style={styles.emptyImg} />
              <Text style={styles.emptyTxt}>Data tidak ditemukan</Text>
            </View>
          }
          ListFooterComponent={lastPage > 1 && (
            <View style={styles.pagination}>
                <TouchableOpacity 
                    disabled={currentPage === 1}
                    onPress={() => setCurrentPage(prev => prev - 1)}
                    style={[styles.pageBtn, currentPage === 1 && styles.btnDisabled]}
                >
                    <ChevronLeft size={20} color="#fff" />
                </TouchableOpacity>
                <View style={styles.pageInfo}>
                    <Text style={styles.pageInfoTxt}>{currentPage} / {lastPage}</Text>
                </View>
                <TouchableOpacity 
                    disabled={currentPage === lastPage}
                    onPress={() => setCurrentPage(prev => prev + 1)}
                    style={[styles.pageBtn, currentPage === lastPage && styles.btnDisabled]}
                >
                    <ChevronRight size={20} color="#fff" />
                </TouchableOpacity>
            </View>
          )}
        />
      )}
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f4f7fa' },
  
  // Header Design
  headerSection: { backgroundColor: '#fff', paddingHorizontal: 20, paddingBottom: 5, borderBottomLeftRadius: 25, borderBottomRightRadius: 25, elevation: 12, shadowColor: '#1e293b', shadowOpacity: 0.1, shadowRadius: 15 },
  headerTop: { flexDirection: 'row', alignItems: 'center', marginBottom: 12 },
  logoCircle: { width: 55, height: 55, borderRadius: 27.5, backgroundColor: '#fff', justifyContent: 'center', alignItems: 'center', elevation: 5, shadowColor: '#000', shadowOpacity: 0.1, shadowRadius: 5, borderWidth: 1, borderColor: '#f1f5f9' },
  logo: { width: 40, height: 45 },
  headerTxtWrapper: { flex: 1, marginLeft: 15 },
  subTitle: { fontSize: 8, color: '#2563eb', fontWeight: '900', letterSpacing: 0.5 },
  mainTitle: { fontSize: 17, fontWeight: '900', color: '#1e293b' },
  countBadge: { backgroundColor: '#1e293b', paddingHorizontal: 10, paddingVertical: 4, borderRadius: 10 },
  countTxt: { color: '#fff', fontSize: 11, fontWeight: '900' },
  
  searchRow: { marginBottom: 10 },
  searchContainer: { flexDirection: 'row', alignItems: 'center', backgroundColor: '#f1f5f9', borderRadius: 15, paddingHorizontal: 15, height: 42 },
  searchInput: { flex: 1, marginLeft: 10, fontSize: 13, color: '#1e293b', fontWeight: '700' },
  
  filterScroll: { flexDirection: 'row', marginBottom: 5 },
  filterTab: { paddingHorizontal: 15, paddingVertical: 6, borderRadius: 10, marginRight: 8, backgroundColor: '#f8fafc', borderWidth: 1, borderColor: '#e2e8f0' },
  filterTabActive: { backgroundColor: '#2563eb', borderColor: '#2563eb', elevation: 5 },
  filterLabel: { fontSize: 11, fontWeight: '900', color: '#64748b' },
  filterLabelActive: { color: '#fff' },

  // List & Card Design
  list: { padding: 20, paddingBottom: 100 },
  cardWrapper: { marginBottom: 18, flexDirection: 'row', position: 'relative' },
  statusStrip: { width: 6, height: '60%', borderRadius: 3, position: 'absolute', left: 0, top: '20%', zIndex: 10 },
  stripBerlaku: { backgroundColor: '#2563eb' },
  stripArsip: { backgroundColor: '#94a3b8' },
  
  cardContainer: { flex: 1, backgroundColor: '#fff', borderRadius: 25, padding: 20, marginLeft: 3, elevation: 5, shadowColor: '#000', shadowOpacity: 0.05, shadowRadius: 15, borderWidth: 1, borderColor: '#f1f5f9' },
  cardArsipBg: { backgroundColor: '#f8fafc', borderColor: '#e2e8f0' },
  
  cardTop: { flexDirection: 'row', alignItems: 'center', marginBottom: 15 },
  iconContainer: { width: 44, height: 44, borderRadius: 14, justifyContent: 'center', alignItems: 'center' },
  iconBerlakuBg: { backgroundColor: '#eff6ff' },
  iconArsipBg: { backgroundColor: '#f1f5f9' },
  
  headerInfo: { flex: 1, marginLeft: 12, flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center' },
  categoryTxt: { fontSize: 10, fontWeight: '900', color: '#2563eb', letterSpacing: 0.5 },
  txtArsipSub: { color: '#94a3b8' },
  
  badge: { paddingHorizontal: 8, paddingVertical: 4, borderRadius: 8 },
  badgeBerlaku: { backgroundColor: '#dcfce7' },
  badgeArsip: { backgroundColor: '#f1f5f9' },
  badgeTxt: { fontSize: 9, fontWeight: '900' },
  badgeTxtBerlaku: { color: '#166534' },
  badgeTxtArsip: { color: '#64748b' },

  titleTxt: { fontSize: 15, fontWeight: '800', color: '#1e293b', lineHeight: 22, marginBottom: 15 },
  txtArsipMain: { color: '#64748b' },
  
  divider: { height: 1, backgroundColor: '#f1f5f9', marginBottom: 15 },
  
  cardBottom: { flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' },
  metaGroup: { flex: 1, flexDirection: 'row', gap: 15 },
  metaItem: { flexDirection: 'row', alignItems: 'center', gap: 6 },
  metaTxt: { fontSize: 11, color: '#94a3b8', fontWeight: '700' },
  
  actionBtn: { width: 32, height: 32, borderRadius: 10, backgroundColor: '#eff6ff', justifyContent: 'center', alignItems: 'center' },

  // Common UI
  center: { flex: 1, justifyContent: 'center', alignItems: 'center', padding: 50 },
  loadingTxt: { marginTop: 15, fontSize: 12, color: '#64748b', fontWeight: '700' },
  emptyImg: { width: 80, height: 80, opacity: 0.1, marginBottom: 20 },
  emptyTxt: { color: '#94a3b8', fontWeight: '800', fontSize: 12 },

  pagination: { flexDirection: 'row', justifyContent: 'center', alignItems: 'center', gap: 15, marginVertical: 20 },
  pageBtn: { backgroundColor: '#1e293b', padding: 12, borderRadius: 15, elevation: 8 },
  btnDisabled: { backgroundColor: '#cbd5e1', elevation: 0 },
  pageInfo: { backgroundColor: '#fff', paddingHorizontal: 20, paddingVertical: 10, borderRadius: 15, borderWidth: 1, borderColor: '#e2e8f0' },
  pageInfoTxt: { fontSize: 14, fontWeight: '900', color: '#1e293b' }
});
