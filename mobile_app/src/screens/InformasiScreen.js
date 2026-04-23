import React, { useState, useEffect, useCallback } from 'react';
import { StyleSheet, Text, View, StatusBar, Image, TouchableOpacity, FlatList, ActivityIndicator, RefreshControl, TextInput } from 'react-native';
import { Accessibility, FileText, Calendar, Building, ChevronRight, ChevronLeft, Archive, CheckCircle2, Search, X, Filter } from 'lucide-react-native';
import { API_ENDPOINTS } from '../api/config';

const STATUSBAR_HEIGHT = StatusBar.currentHeight || 0;

export default function InformasiScreen() {
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const [documents, setDocuments] = useState([]);
  const [error, setError] = useState(null);
  
  // State Filter & Search
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
      setCurrentPage(1); // Reset ke halaman 1 setiap kali filter berubah
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
      <TouchableOpacity style={[styles.card, isArsip && styles.cardArsip]} activeOpacity={0.7}>
        <View style={styles.cardContent}>
          <View style={[styles.iconBox, isArsip ? styles.iconArsip : styles.iconBerlaku]}>
              {isArsip ? <Archive size={22} color="#64748b" /> : <CheckCircle2 size={22} color="#2563eb" />}
          </View>

          <View style={styles.infoBox}>
            <View style={styles.badgeRow}>
                <Text style={[styles.categoryTxt, isArsip && styles.txtGray]}>{item.category || 'DIP'}</Text>
                <View style={[styles.statusTag, isArsip ? styles.tagArsip : styles.tagBerlaku]}>
                    <Text style={styles.tagTxt}>{item.status}</Text>
                </View>
            </View>
            
            <Text style={[styles.titleTxt, isArsip && styles.txtGray]} numberOfLines={2}>
                {item.title}
            </Text>
            
            <View style={styles.metaRow}>
              <View style={styles.metaItem}>
                <Calendar size={12} color="#94a3b8" />
                <Text style={styles.metaTxt}>{item.tanggal_upload || 'Terbaru'}</Text>
              </View>
              {/* PERBAIKAN: Gunakan flex:1 agar nama dinas tidak meluap */}
              <View style={[styles.metaItem, { flex: 1, marginLeft: 12 }]}>
                <Building size={12} color="#94a3b8" />
                <Text style={styles.metaTxt} numberOfLines={1} ellipsizeMode="trailing">
                    {item.organization_name || 'Sekretariat'}
                </Text>
              </View>
            </View>
          </View>
        </View>
      </TouchableOpacity>
    );
  };

  return (
    <View style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="transparent" translucent={true} />

      {/* HEADER & SEARCH SECTION */}
      <View style={[styles.headerSection, { paddingTop: STATUSBAR_HEIGHT + 10 }]}>
          <View style={styles.headerTop}>
            <Image source={require('../../assets/logo_ppid.webp')} style={styles.logo} resizeMode="contain" />
            <View style={styles.headerTxt}>
              <Text style={styles.subTitle}>DATA INFORMASI ({totalData})</Text>
              <Text style={styles.mainTitle}>Daftar Dokumen</Text>
            </View>
          </View>

          {/* Kolom Pencarian */}
          <View style={styles.searchBox}>
            <Search size={18} color="#94a3b8" />
            <TextInput 
                style={styles.searchInput}
                placeholder="Cari judul, dinas, atau kategori..."
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

          {/* Filter Status */}
          <View style={styles.filterRow}>
            {['Semua', 'BERLAKU', 'ARSIP'].map((status) => (
                <TouchableOpacity 
                    key={status}
                    onPress={() => setSelectedStatus(status)}
                    style={[styles.filterChip, selectedStatus === status && styles.filterChipActive]}
                >
                    <Text style={[styles.filterTxt, selectedStatus === status && styles.filterTxtActive]}>
                        {status}
                    </Text>
                </TouchableOpacity>
            ))}
          </View>
      </View>

      {loading && !refreshing && documents.length === 0 ? (
        <View style={styles.center}>
          <ActivityIndicator size="large" color="#2563eb" />
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
              <FileText size={48} color="#cbd5e1" />
              <Text style={styles.emptyTxt}>Dokumen tidak ditemukan</Text>
            </View>
          }
          ListFooterComponent={lastPage > 1 && (
            <View style={styles.pagination}>
                <TouchableOpacity 
                    disabled={currentPage === 1}
                    onPress={() => fetchDocuments(currentPage - 1, searchQuery, selectedStatus)}
                    style={[styles.pageBtn, currentPage === 1 && {opacity: 0.5}]}
                >
                    <ChevronLeft size={20} color="#fff" />
                </TouchableOpacity>
                <Text style={styles.pageIndicator}>{currentPage} / {lastPage}</Text>
                <TouchableOpacity 
                    disabled={currentPage === lastPage}
                    onPress={() => fetchDocuments(currentPage + 1, searchQuery, selectedStatus)}
                    style={[styles.pageBtn, currentPage === lastPage && {opacity: 0.5}]}
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
  container: { flex: 1, backgroundColor: '#f8fafc' },
  headerSection: { backgroundColor: '#fff', paddingHorizontal: 20, paddingBottom: 15, borderBottomWidth: 1, borderBottomColor: '#f1f5f9', elevation: 10, shadowColor: '#000', shadowOpacity: 0.05, shadowRadius: 10 },
  headerTop: { flexDirection: 'row', alignItems: 'center', marginBottom: 15 },
  logo: { width: 40, height: 40, marginRight: 15 },
  headerTxt: { flex: 1 },
  subTitle: { fontSize: 10, color: '#94a3b8', fontWeight: '900' },
  mainTitle: { fontSize: 18, fontWeight: '900', color: '#1e293b' },
  
  searchBox: { flexDirection: 'row', alignItems: 'center', backgroundColor: '#f1f5f9', borderRadius: 15, paddingHorizontal: 15, height: 45, marginBottom: 12 },
  searchInput: { flex: 1, marginLeft: 10, fontSize: 13, color: '#1e293b', fontWeight: '600' },
  
  filterRow: { flexDirection: 'row', gap: 10 },
  filterChip: { paddingHorizontal: 15, paddingVertical: 6, borderRadius: 10, backgroundColor: '#f1f5f9', borderWidth: 1, borderColor: '#e2e8f0' },
  filterChipActive: { backgroundColor: '#2563eb', borderColor: '#2563eb' },
  filterTxt: { fontSize: 11, fontWeight: '800', color: '#64748b' },
  filterTxtActive: { color: '#fff' },

  list: { padding: 15, paddingBottom: 100 },
  card: { backgroundColor: '#fff', borderRadius: 20, padding: 15, marginBottom: 12, elevation: 3, shadowColor: '#000', shadowOpacity: 0.03, shadowRadius: 8, borderWidth: 1, borderColor: '#f1f5f9' },
  cardArsip: { backgroundColor: '#f8fafc', elevation: 0 },
  cardContent: { flexDirection: 'row', alignItems: 'center' },
  iconBox: { width: 48, height: 48, borderRadius: 14, justifyContent: 'center', alignItems: 'center', marginRight: 15 },
  iconBerlaku: { backgroundColor: '#eff6ff' },
  iconArsip: { backgroundColor: '#f1f5f9' },
  
  infoBox: { flex: 1 },
  badgeRow: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', marginBottom: 5 },
  categoryTxt: { fontSize: 9, color: '#2563eb', fontWeight: '900' },
  statusTag: { paddingHorizontal: 6, paddingVertical: 2, borderRadius: 5 },
  tagBerlaku: { backgroundColor: '#dcfce7' },
  tagArsip: { backgroundColor: '#f1f5f9' },
  tagTxt: { fontSize: 8, fontWeight: '900', color: '#1e293b' },
  titleTxt: { fontSize: 13, fontWeight: '800', color: '#1e293b', lineHeight: 18 },
  txtGray: { color: '#94a3b8' },
  
  metaRow: { flexDirection: 'row', alignItems: 'center', marginTop: 10 },
  metaItem: { flexDirection: 'row', alignItems: 'center', gap: 5 },
  metaTxt: { fontSize: 10, color: '#94a3b8', fontWeight: '700' },

  pagination: { flexDirection: 'row', justifyContent: 'center', alignItems: 'center', gap: 20, marginTop: 10, marginBottom: 30 },
  pageBtn: { backgroundColor: '#2563eb', padding: 10, borderRadius: 12, elevation: 5 },
  pageIndicator: { fontSize: 14, fontWeight: '900', color: '#1e293b' },
  center: { flex: 1, justifyContent: 'center', alignItems: 'center', padding: 50 },
  emptyTxt: { marginTop: 15, color: '#94a3b8', fontWeight: '800' }
});
