import React, { useState, useEffect } from 'react';
import { StyleSheet, Text, View, StatusBar, Image, TouchableOpacity, ScrollView, ActivityIndicator, RefreshControl, Linking } from 'react-native';
import { Building2, Mail, Phone, MapPin, Globe, Eye, Target, Share2 } from 'lucide-react-native';
import { MaterialCommunityIcons } from '@expo/vector-icons';
import { LinearGradient } from 'expo-linear-gradient';
import { API_ENDPOINTS } from '../api/config';

const STATUSBAR_HEIGHT = StatusBar.currentHeight || 0;

export default function ProfilScreen() {
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const [profil, setProfil] = useState(null);

  const fetchProfil = async () => {
    try {
      setLoading(true);
      const response = await fetch(API_ENDPOINTS.PROFIL);
      const result = await response.json();
      if (result.success) {
        setProfil(result.data);
      }
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  useEffect(() => {
    fetchProfil();
  }, []);

  const openLink = (url) => {
    if (url) {
        // Tambahkan https:// jika belum ada agar tidak error di Android
        const finalUrl = url.startsWith('http') ? url : `https://${url}`;
        Linking.openURL(finalUrl);
    }
  };

  if (loading && !refreshing) {
    return (
      <View style={styles.center}>
        <ActivityIndicator size="large" color="#2563eb" />
        <Text style={styles.loadingText}>Memuat Profil Resmi...</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="transparent" translucent={true} />

      <View style={[styles.headerSection, { paddingTop: STATUSBAR_HEIGHT + 10 }]}>
          <View style={styles.headerTop}>
            <View style={styles.logoCircle}>
                <Image source={require('../../assets/icon.webp')} style={styles.logo} resizeMode="contain" />
            </View>
            <View style={styles.headerTxtWrapper}>
              <Text style={styles.subTitle}>INFO INSTANSI</Text>
              <Text style={styles.mainTitle}>Profil PPID</Text>
            </View>
            <TouchableOpacity style={styles.shareBtn} onPress={() => openLink(profil?.website)}>
                <Globe size={20} color="#2563eb" />
            </TouchableOpacity>
          </View>
      </View>

      <ScrollView 
        showsVerticalScrollIndicator={false}
        contentContainerStyle={styles.scrollContent}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={() => {setRefreshing(true); fetchProfil();}} colors={['#2563eb']} />}
      >
        {/* HERO CARD DENGAN DATA BENAR */}
        <View style={styles.heroCard}>
            <LinearGradient colors={['#2563eb', '#1e40af']} style={styles.heroGradient}>
                <Building2 size={40} color="rgba(255,255,255,0.2)" style={styles.heroBgIcon} />
                <Text style={styles.heroTitle}>PPID Kabupaten Sinjai</Text>
                <Text style={styles.heroSubtitle}>Pejabat Pengelola Informasi dan Dokumentasi</Text>
            </LinearGradient>
            
            <View style={styles.actionRow}>
                <TouchableOpacity style={styles.actionItem} onPress={() => openLink(`tel:${profil?.phone}`)}>
                    <View style={[styles.actionIcon, { backgroundColor: '#eff6ff' }]}><Phone size={18} color="#2563eb" /></View>
                    <Text style={styles.actionLabel}>Hubungi</Text>
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

        {/* VISI & MISI */}
        <View style={styles.sectionCard}>
            <View style={styles.sectionHeader}>
                <View style={styles.iconBox}><Eye size={18} color="#2563eb" /></View>
                <Text style={styles.sectionTitle}>Visi</Text>
            </View>
            <Text style={styles.visionText}>{profil?.vision}</Text>
        </View>

        <View style={styles.sectionCard}>
            <View style={styles.sectionHeader}>
                <View style={[styles.iconBox, { backgroundColor: '#f0fdf4' }]}><Target size={18} color="#16a34a" /></View>
                <Text style={styles.sectionTitle}>Misi</Text>
            </View>
            {Array.isArray(profil?.mission) && profil.mission.map((item, index) => (
                <View key={index} style={styles.misiItem}>
                    <View style={styles.misiBullet} />
                    <Text style={styles.misiText}>{item}</Text>
                </View>
            ))}
        </View>

        {/* STRUKTUR ORGANISASI - Fallback if missing */}
        <View style={styles.sectionCard}>
            <View style={styles.sectionHeader}>
                <View style={[styles.iconBox, { backgroundColor: '#fef2f2' }]}><Share2 size={18} color="#dc2626" /></View>
                <Text style={styles.sectionTitle}>Struktur Organisasi</Text>
            </View>
            {profil?.structure_image ? (
                <Image 
                    source={{ uri: profil.structure_image }} 
                    style={styles.structureImg}
                    resizeMode="contain"
                />
            ) : (
                <View style={styles.emptyStructure}>
                    <Building2 size={32} color="#cbd5e1" strokeWidth={1} />
                    <Text style={styles.emptyTxt}>Bagan struktur belum tersedia</Text>
                </View>
            )}
        </View>

        {/* MEDIA SOSIAL - Fix "Kotak-kotak" with MaterialCommunityIcons */}
        <View style={styles.socialCard}>
            <Text style={styles.socialTitle}>MEDIA SOSIAL RESMI</Text>
            <View style={styles.socialRow}>
                <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil?.instagram)}>
                    <MaterialCommunityIcons name="instagram" size={28} color="#e1306c" />
                </TouchableOpacity>
                <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil?.facebook)}>
                    <MaterialCommunityIcons name="facebook" size={28} color="#1877f2" />
                </TouchableOpacity>
                <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil?.twitter)}>
                    <MaterialCommunityIcons name="twitter" size={28} color="#1da1f2" />
                </TouchableOpacity>
                <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil?.youtube)}>
                    <MaterialCommunityIcons name="youtube" size={28} color="#ff0000" />
                </TouchableOpacity>
            </View>
        </View>

        <View style={styles.footerInfo}>
            <Text style={styles.footerTxt}>Dikelola oleh Dinas Kominfo Sinjai</Text>
            <Text style={styles.footerVersion}>Aplikasi PPID Mobile v1.0.2</Text>
        </View>

        <View style={{ height: 100 }} />
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f8fafc' },
  headerSection: { backgroundColor: '#fff', paddingHorizontal: 20, paddingBottom: 12, borderBottomLeftRadius: 25, borderBottomRightRadius: 25, elevation: 12 },
  headerTop: { flexDirection: 'row', alignItems: 'center' },
  logoCircle: { width: 55, height: 55, borderRadius: 27.5, backgroundColor: '#fff', justifyContent: 'center', alignItems: 'center', elevation: 5 },
  logo: { width: 40, height: 45 },
  headerTxtWrapper: { flex: 1, marginLeft: 15 },
  subTitle: { fontSize: 8, color: '#2563eb', fontWeight: '900' },
  mainTitle: { fontSize: 17, fontWeight: '900', color: '#1e293b' },
  shareBtn: { width: 40, height: 40, borderRadius: 12, backgroundColor: '#f1f5f9', justifyContent: 'center', alignItems: 'center' },
  
  scrollContent: { padding: 20 },
  
  heroCard: { backgroundColor: '#fff', borderRadius: 25, overflow: 'hidden', elevation: 8, marginBottom: 20 },
  heroGradient: { padding: 25, paddingVertical: 25, position: 'relative' },
  heroBgIcon: { position: 'absolute', right: -10, bottom: -10 },
  heroTitle: { color: '#fff', fontSize: 18, fontWeight: '900', marginBottom: 5 },
  heroSubtitle: { color: 'rgba(255,255,255,0.8)', fontSize: 12, fontWeight: '600' },
  
  actionRow: { flexDirection: 'row', justifyContent: 'space-around', paddingVertical: 12 },
  actionItem: { alignItems: 'center', gap: 4 },
  actionIcon: { width: 44, height: 44, borderRadius: 22, justifyContent: 'center', alignItems: 'center' },
  actionLabel: { fontSize: 9, fontWeight: '800', color: '#64748b' },
  
  sectionCard: { backgroundColor: '#fff', borderRadius: 22, padding: 20, marginBottom: 15, elevation: 3, borderWidth: 1, borderColor: '#f1f5f9' },
  sectionHeader: { flexDirection: 'row', alignItems: 'center', gap: 10, marginBottom: 12 },
  iconBox: { width: 32, height: 32, borderRadius: 8, backgroundColor: '#eff6ff', justifyContent: 'center', alignItems: 'center' },
  sectionTitle: { fontSize: 12, fontWeight: '900', color: '#1e293b', textTransform: 'uppercase' },
  visionText: { fontSize: 13, color: '#475569', lineHeight: 20, fontWeight: '600', fontStyle: 'italic', textAlign: 'center' },
  
  misiItem: { flexDirection: 'row', alignItems: 'flex-start', marginBottom: 8, gap: 8 },
  misiBullet: { width: 6, height: 6, borderRadius: 3, backgroundColor: '#2563eb', marginTop: 7 },
  misiText: { flex: 1, fontSize: 13, color: '#475569', lineHeight: 20, fontWeight: '600' },
  
  structureImg: { width: '100%', height: 220, borderRadius: 12 },
  emptyStructure: { height: 120, justifyContent: 'center', alignItems: 'center', backgroundColor: '#f8fafc', borderRadius: 15, borderStyle: 'dashed', borderWidth: 1, borderColor: '#cbd5e1' },
  emptyTxt: { fontSize: 11, color: '#94a3b8', fontWeight: '700', marginTop: 8 },
  
  socialCard: { alignItems: 'center', padding: 20, backgroundColor: '#fff', borderRadius: 25, elevation: 3, marginBottom: 20 },
  socialTitle: { fontSize: 10, fontWeight: '900', color: '#94a3b8', marginBottom: 15, letterSpacing: 1 },
  socialRow: { flexDirection: 'row', gap: 20 },
  socialBtn: { width: 50, height: 50, borderRadius: 25, backgroundColor: '#f8fafc', justifyContent: 'center', alignItems: 'center', borderWidth: 1, borderColor: '#eff6ff' },
  
  footerInfo: { alignItems: 'center', marginTop: 10 },
  footerTxt: { fontSize: 11, fontWeight: '900', color: '#cbd5e1' },
  footerVersion: { fontSize: 9, fontWeight: '700', color: '#e2e8f0', marginTop: 4 },
  center: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: '#fff' },
  loadingText: { marginTop: 15, fontSize: 12, color: '#64748b', fontWeight: '800' }
});
