import React, { useState, useEffect } from 'react';
import { StyleSheet, Text, View, StatusBar, Image, TouchableOpacity, ScrollView, ActivityIndicator, RefreshControl } from 'react-native';
import { Accessibility, Building2, Mail, Phone, MapPin, Globe, Eye, Target } from 'lucide-react-native';
import { API_ENDPOINTS } from '../api/config';

const STATUSBAR_HEIGHT = StatusBar.currentHeight || 0;

export default function ProfilScreen() {
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const [profil, setProfil] = useState(null);
  const [error, setError] = useState(null);

  const fetchProfil = async () => {
    try {
      setLoading(true);
      const response = await fetch(API_ENDPOINTS.PROFIL);
      const result = await response.json();
      
      if (result.success) {
        setProfil(result.data);
        setError(null);
      } else {
        setError('Gagal memuat profil PPID');
      }
    } catch (err) {
      setError('Koneksi server terganggu');
      console.error(err);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  useEffect(() => {
    fetchProfil();
  }, []);

  const onRefresh = () => {
    setRefreshing(true);
    fetchProfil();
  };

  if (loading && !refreshing) {
    return (
      <View style={styles.centerContent}>
        <ActivityIndicator size="large" color="#2563eb" />
        <Text style={styles.loadingText}>Menyiapkan profil...</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="transparent" translucent={true} />

      <View style={[styles.headerContainer, { paddingTop: STATUSBAR_HEIGHT + 10 }]}>
          <View style={styles.headerContent}>
            <Image source={require('../../assets/logo_ppid.webp')} style={styles.headerLogo} resizeMode="contain" />
            <View style={styles.headerTextWrapper}>
              <Text style={styles.welcomeLabel}>Tentang OPD</Text>
              <Text style={styles.brandLabel}>Profil PPID</Text>
            </View>
            <TouchableOpacity style={styles.headerActionBtn}>
                <Accessibility size={24} color="#2563eb" strokeWidth={2.5} />
            </TouchableOpacity>
          </View>
      </View>

      <ScrollView 
        contentContainerStyle={styles.scrollContent}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={['#2563eb']} />}
      >
        {/* Visi Section */}
        <View style={styles.sectionCard}>
            <View style={styles.sectionHeader}>
                <Eye size={20} color="#2563eb" />
                <Text style={styles.sectionTitle}>Visi Kami</Text>
            </View>
            <Text style={styles.sectionDesc}>
                {profil?.vision || 'Mewujudkan pelayanan informasi publik yang transparan, akuntabel, dan profesional.'}
            </Text>
        </View>

        {/* Misi Section */}
        <View style={styles.sectionCard}>
            <View style={styles.sectionHeader}>
                <Target size={20} color="#2563eb" />
                <Text style={styles.sectionTitle}>Misi Kami</Text>
            </View>
            {profil?.mission && Array.isArray(profil.mission) ? (
                profil.mission.map((item, index) => (
                    <View key={index} style={styles.misiItem}>
                        <View style={styles.misiBullet} />
                        <Text style={styles.misiText}>{item}</Text>
                    </View>
                ))
            ) : (
                <View style={styles.misiItem}>
                    <View style={styles.misiBullet} />
                    <Text style={styles.misiText}>Menyediakan informasi publik yang akurat dan tepat waktu.</Text>
                </View>
            )}
        </View>

        {/* Kontak Section */}
        <View style={styles.sectionCard}>
            <View style={styles.sectionHeader}>
                <Building2 size={20} color="#2563eb" />
                <Text style={styles.sectionTitle}>Kontak & Alamat</Text>
            </View>
            
            <View style={styles.contactRow}>
                <MapPin size={18} color="#94a3b8" />
                <Text style={styles.contactText}>{profil?.address || 'Jl. Persatuan Raya No. 5, Sinjai'}</Text>
            </View>

            <View style={styles.contactRow}>
                <Phone size={18} color="#94a3b8" />
                <Text style={styles.contactText}>{profil?.phone || '(0482) 21011'}</Text>
            </View>

            <View style={styles.contactRow}>
                <Mail size={18} color="#94a3b8" />
                <Text style={styles.contactText}>{profil?.email || 'ppid@sinjaikab.go.id'}</Text>
            </View>

            <View style={styles.contactRow}>
                <Globe size={18} color="#94a3b8" />
                <Text style={styles.contactText}>{profil?.website || 'ppid.sinjaikab.go.id'}</Text>
            </View>
        </View>

        <View style={{ height: 100 }} />
      </ScrollView>
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
  
  scrollContent: { padding: 20 },
  sectionCard: { backgroundColor: '#fff', borderRadius: 25, padding: 20, marginBottom: 20, elevation: 4, shadowColor: '#000', shadowOpacity: 0.05, shadowRadius: 15, borderWidth: 1, borderColor: '#f1f5f9' },
  sectionHeader: { flexDirection: 'row', alignItems: 'center', gap: 10, marginBottom: 15 },
  sectionTitle: { fontSize: 15, fontWeight: '900', color: '#1e293b', textTransform: 'uppercase', letterSpacing: 0.5 },
  sectionDesc: { fontSize: 13, color: '#64748b', lineHeight: 22, fontWeight: '600' },
  
  misiItem: { flexDirection: 'row', alignItems: 'flex-start', marginBottom: 10, gap: 12 },
  misiBullet: { width: 6, height: 6, borderRadius: 3, backgroundColor: '#2563eb', marginTop: 8 },
  misiText: { flex: 1, fontSize: 13, color: '#64748b', lineHeight: 22, fontWeight: '600' },

  contactRow: { flexDirection: 'row', alignItems: 'center', gap: 15, marginBottom: 15 },
  contactText: { flex: 1, fontSize: 13, color: '#64748b', fontWeight: '700' },

  centerContent: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: '#f8fafc' },
  loadingText: { marginTop: 15, fontSize: 12, color: '#64748b', fontWeight: '700' }
});
