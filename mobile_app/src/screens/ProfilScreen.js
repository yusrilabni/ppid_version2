import React, { useState, useEffect } from 'react';
import { StyleSheet, Text, View, StatusBar, Image, TouchableOpacity, ScrollView, ActivityIndicator, RefreshControl, Linking } from 'react-native';
import { Accessibility, Building2, Mail, Phone, MapPin, Globe, Eye, Target, Instagram, Facebook, Twitter, Youtube, ChevronRight, Share2 } from 'lucide-react-native';
import { LinearGradient } from 'expo-linear-gradient';
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
        setError('Gagal memuat profil');
      }
    } catch (err) {
      setError('Koneksi terganggu');
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

  const openLink = (url) => {
    if (url) Linking.openURL(url);
  };

  if (loading && !refreshing) {
    return (
      <View style={styles.center}>
        <ActivityIndicator size="large" color="#2563eb" />
        <Text style={styles.loadingText}>Menyiapkan Profil Premium...</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="transparent" translucent={true} />

      {/* HEADER PREMIUM RAMPII */}
      <View style={[styles.headerSection, { paddingTop: STATUSBAR_HEIGHT + 10 }]}>
          <View style={styles.headerTop}>
            <View style={styles.logoCircle}>
                <Image source={require('../../assets/icon.webp')} style={styles.logo} resizeMode="contain" />
            </View>
            <View style={styles.headerTxtWrapper}>
              <Text style={styles.subTitle}>TENTANG KAMI</Text>
              <Text style={styles.mainTitle}>Profil PPID</Text>
            </View>
            <TouchableOpacity style={styles.shareBtn} onPress={() => openLink(profil?.website || 'https://ppidkab.sinjaikab.go.id')}>
                <Globe size={20} color="#2563eb" strokeWidth={2.5} />
            </TouchableOpacity>
          </View>
      </View>

      <ScrollView 
        showsVerticalScrollIndicator={false}
        contentContainerStyle={styles.scrollContent}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={['#2563eb']} />}
      >
        {/* HERO SECTION / IDENTITY */}
        <View style={styles.heroCard}>
            <LinearGradient colors={['#2563eb', '#1e40af']} style={styles.heroGradient}>
                <Building2 size={40} color="rgba(255,255,255,0.2)" style={styles.heroBgIcon} />
                <Text style={styles.heroTitle}>PPID Kabupaten Sinjai</Text>
                <Text style={styles.heroSubtitle}>Transparansi & Akuntabilitas Informasi Publik</Text>
            </LinearGradient>
            
            {/* Quick Actions */}
            <View style={styles.actionRow}>
                <TouchableOpacity style={styles.actionItem} onPress={() => openLink(`tel:${profil?.phone}`)}>
                    <View style={[styles.actionIcon, { backgroundColor: '#eff6ff' }]}><Phone size={18} color="#2563eb" /></View>
                    <Text style={styles.actionLabel}>Telepon</Text>
                </TouchableOpacity>
                <TouchableOpacity style={styles.actionItem} onPress={() => openLink(`mailto:${profil?.email}`)}>
                    <View style={[styles.actionIcon, { backgroundColor: '#f0fdf4' }]}><Mail size={18} color="#16a34a" /></View>
                    <Text style={styles.actionLabel}>Email</Text>
                </TouchableOpacity>
                <TouchableOpacity style={styles.actionItem} onPress={() => openLink(profil?.maps_url)}>
                    <View style={[styles.actionIcon, { backgroundColor: '#fff7ed' }]}><MapPin size={18} color="#ea580c" /></View>
                    <Text style={styles.actionLabel}>Lokasi</Text>
                </TouchableOpacity>
            </View>
        </View>

        {/* VISI SECTION */}
        <View style={styles.sectionCard}>
            <View style={styles.sectionHeader}>
                <View style={styles.iconBox}><Eye size={20} color="#2563eb" /></View>
                <Text style={styles.sectionTitle}>Visi Kami</Text>
            </View>
            <Text style={styles.visionText}>
                {profil?.vision || 'Mewujudkan pelayanan informasi publik yang transparan, akuntabel, dan profesional.'}
            </Text>
        </View>

        {/* MISI SECTION */}
        <View style={styles.sectionCard}>
            <View style={styles.sectionHeader}>
                <View style={[styles.iconBox, { backgroundColor: '#f0fdf4' }]}><Target size={20} color="#16a34a" /></View>
                <Text style={styles.sectionTitle}>Misi Utama</Text>
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
                    <Text style={styles.misiText}>Memberikan pelayanan informasi yang cepat, tepat, dan sederhana.</Text>
                </View>
            )}
        </View>

        {/* STRUKTUR ORGANISASI (Jika Ada) */}
        {profil?.structure_image && (
            <View style={styles.sectionCard}>
                <View style={styles.sectionHeader}>
                    <View style={[styles.iconBox, { backgroundColor: '#fef2f2' }]}><Share2 size={20} color="#dc2626" /></View>
                    <Text style={styles.sectionTitle}>Struktur Organisasi</Text>
                </View>
                <Image 
                    source={{ uri: `https://ppidkab.sinjaikab.go.id/storage/${profil.structure_image}` }} 
                    style={styles.structureImg}
                    resizeMode="contain"
                />
            </View>
        )}

        {/* SOCIAL MEDIA SECTION */}
        <View style={styles.socialCard}>
            <Text style={styles.socialTitle}>Ikuti Media Sosial Kami</Text>
            <View style={styles.socialRow}>
                {profil?.instagram && (
                    <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil.instagram)}>
                        <Instagram size={24} color="#e1306c" />
                    </TouchableOpacity>
                )}
                {profil?.facebook && (
                    <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil.facebook)}>
                        <Facebook size={24} color="#1877f2" />
                    </TouchableOpacity>
                )}
                {profil?.twitter && (
                    <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil.twitter)}>
                        <Twitter size={24} color="#1da1f2" />
                    </TouchableOpacity>
                )}
                {profil?.youtube && (
                    <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil.youtube)}>
                        <Youtube size={24} color="#ff0000" />
                    </TouchableOpacity>
                )}
            </View>
        </View>

        {/* FOOTER INFO */}
        <View style={styles.footerInfo}>
            <Text style={styles.footerTxt}>PPID Kabupaten Sinjai</Text>
            <Text style={styles.footerVersion}>Versi Aplikasi 1.0.0</Text>
        </View>

        <View style={{ height: 100 }} />
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f8fafc' },
  
  // Header Design
  headerSection: { backgroundColor: '#fff', paddingHorizontal: 20, paddingBottom: 15, borderBottomLeftRadius: 25, borderBottomRightRadius: 25, elevation: 12, shadowColor: '#1e293b', shadowOpacity: 0.1, shadowRadius: 15 },
  headerTop: { flexDirection: 'row', alignItems: 'center' },
  logoCircle: { width: 55, height: 55, borderRadius: 27.5, backgroundColor: '#fff', justifyContent: 'center', alignItems: 'center', elevation: 5, borderWidth: 1, borderColor: '#f1f5f9' },
  logo: { width: 40, height: 45 },
  headerTxtWrapper: { flex: 1, marginLeft: 15 },
  subTitle: { fontSize: 8, color: '#2563eb', fontWeight: '900', letterSpacing: 0.5 },
  mainTitle: { fontSize: 17, fontWeight: '900', color: '#1e293b' },
  shareBtn: { width: 40, height: 40, borderRadius: 12, backgroundColor: '#f1f5f9', justifyContent: 'center', alignItems: 'center' },

  scrollContent: { padding: 20 },

  // Hero Card
  heroCard: { backgroundColor: '#fff', borderRadius: 25, overflow: 'hidden', elevation: 10, shadowColor: '#1e293b', shadowOpacity: 0.1, shadowRadius: 15, marginBottom: 25 },
  heroGradient: { padding: 25, paddingVertical: 35, position: 'relative' },
  heroBgIcon: { position: 'absolute', right: -10, bottom: -10 },
  heroTitle: { color: '#fff', fontSize: 18, fontWeight: '900', marginBottom: 5 },
  heroSubtitle: { color: 'rgba(255,255,255,0.8)', fontSize: 12, fontWeight: '600', lineHeight: 18 },
  
  actionRow: { flexDirection: 'row', justifyContent: 'space-around', paddingVertical: 20, borderTopWidth: 1, borderTopColor: '#f1f5f9' },
  actionItem: { alignItems: 'center', gap: 8 },
  actionIcon: { width: 48, height: 48, borderRadius: 24, justifyContent: 'center', alignItems: 'center' },
  actionLabel: { fontSize: 10, fontWeight: '800', color: '#64748b' },

  // Section Card
  sectionCard: { backgroundColor: '#fff', borderRadius: 25, padding: 20, marginBottom: 20, elevation: 5, shadowColor: '#000', shadowOpacity: 0.05, shadowRadius: 10, borderWidth: 1, borderColor: '#f1f5f9' },
  sectionHeader: { flexDirection: 'row', alignItems: 'center', gap: 12, marginBottom: 15 },
  iconBox: { width: 36, height: 36, borderRadius: 10, backgroundColor: '#eff6ff', justifyContent: 'center', alignItems: 'center' },
  sectionTitle: { fontSize: 14, fontWeight: '900', color: '#1e293b', textTransform: 'uppercase' },
  visionText: { fontSize: 14, color: '#475569', lineHeight: 24, fontWeight: '600', fontStyle: 'italic', textAlign: 'center', paddingHorizontal: 10 },
  
  misiItem: { flexDirection: 'row', alignItems: 'flex-start', marginBottom: 12, gap: 12 },
  misiBullet: { width: 8, height: 8, borderRadius: 4, backgroundColor: '#2563eb', marginTop: 8 },
  misiText: { flex: 1, fontSize: 13, color: '#475569', lineHeight: 22, fontWeight: '600' },

  structureImg: { width: '100%', height: 200, marginTop: 10, borderRadius: 15 },

  // Social Media
  socialCard: { alignItems: 'center', padding: 25, backgroundColor: '#fff', borderRadius: 25, marginBottom: 20, elevation: 3, borderWidth: 1, borderColor: '#f1f5f9' },
  socialTitle: { fontSize: 12, fontWeight: '900', color: '#94a3b8', marginBottom: 20, textTransform: 'uppercase' },
  socialRow: { flexDirection: 'row', gap: 25 },
  socialBtn: { width: 50, height: 50, borderRadius: 25, backgroundColor: '#f8fafc', justifyContent: 'center', alignItems: 'center', borderWidth: 1, borderColor: '#eff6ff' },

  // Footer
  footerInfo: { alignItems: 'center', marginTop: 10 },
  footerTxt: { fontSize: 12, fontWeight: '900', color: '#cbd5e1' },
  footerVersion: { fontSize: 10, fontWeight: '700', color: '#e2e8f0', marginTop: 5 },

  center: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: '#fff' },
  loadingText: { marginTop: 15, fontSize: 12, color: '#64748b', fontWeight: '800' }
});
