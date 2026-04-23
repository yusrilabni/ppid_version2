import React, { useState, useEffect } from 'react';
import { StyleSheet, Text, View, StatusBar, Image, TouchableOpacity, ScrollView, ActivityIndicator, RefreshControl, Linking } from 'react-native';
import { Building2, Mail, Phone, MapPin, Globe, Eye, Target, Share2 } from 'lucide-react-native';
import { Ionicons } from '@expo/vector-icons';
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
    if (url) Linking.openURL(url);
  };

  if (loading && !refreshing) {
    return (
      <View style={styles.center}>
        <ActivityIndicator size="large" color="#2563eb" />
        <Text style={styles.loadingText}>Memuat Data Resmi...</Text>
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
              <Text style={styles.subTitle}>DATA & PROFIL</Text>
              <Text style={styles.mainTitle}>PPID Sinjai</Text>
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
        {/* CONTACT CARD */}
        <View style={styles.heroCard}>
            <LinearGradient colors={['#2563eb', '#1e40af']} style={styles.heroGradient}>
                <Building2 size={40} color="rgba(255,255,255,0.2)" style={styles.heroBgIcon} />
                <Text style={styles.heroTitle}>PPID Kabupaten Sinjai</Text>
                <Text style={styles.heroSubtitle}>Layanan Informasi Publik Terpadu</Text>
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
                <View style={styles.iconBox}><Eye size={20} color="#2563eb" /></View>
                <Text style={styles.sectionTitle}>Visi Kami</Text>
            </View>
            <Text style={styles.visionText}>"{profil?.vision}"</Text>
        </View>

        <View style={styles.sectionCard}>
            <View style={styles.sectionHeader}>
                <View style={[styles.iconBox, { backgroundColor: '#f0fdf4' }]}><Target size={20} color="#16a34a" /></View>
                <Text style={styles.sectionTitle}>Misi Utama</Text>
            </View>
            {Array.isArray(profil?.mission) && profil.mission.map((item, index) => (
                <View key={index} style={styles.misiItem}>
                    <View style={styles.misiBullet} />
                    <Text style={styles.misiText}>{item}</Text>
                </View>
            ))}
        </View>

        {/* STRUKTUR ORGANISASI */}
        <View style={styles.sectionCard}>
            <View style={styles.sectionHeader}>
                <View style={[styles.iconBox, { backgroundColor: '#fef2f2' }]}><Share2 size={20} color="#dc2626" /></View>
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
                    <Text style={styles.emptyTxt}>Bagan struktur belum diunggah</Text>
                </View>
            )}
        </View>

        {/* SOSIAL MEDIA - Perbaikan Ikon Kotak-Kotak */}
        <View style={styles.socialCard}>
            <Text style={styles.socialTitle}>Ikuti Kami di Media Sosial</Text>
            <View style={styles.socialRow}>
                <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil?.instagram)}>
                    <Ionicons name="logo-instagram" size={26} color="#e1306c" />
                </TouchableOpacity>
                <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil?.facebook)}>
                    <Ionicons name="logo-facebook" size={26} color="#1877f2" />
                </TouchableOpacity>
                <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil?.twitter)}>
                    <Ionicons name="logo-twitter" size={26} color="#1da1f2" />
                </TouchableOpacity>
                <TouchableOpacity style={styles.socialBtn} onPress={() => openLink(profil?.youtube)}>
                    <Ionicons name="logo-youtube" size={26} color="#ff0000" />
                </TouchableOpacity>
            </View>
        </View>

        <View style={styles.footerInfo}>
            <Text style={styles.footerTxt}>PPID Kabupaten Sinjai © 2026</Text>
            <Text style={styles.footerVersion}>v1.0.2 - Premium Edition</Text>
        </View>

        <View style={{ height: 100 }} />
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f8fafc' },
  headerSection: { backgroundColor: '#fff', paddingHorizontal: 20, paddingBottom: 15, borderBottomLeftRadius: 25, borderBottomRightRadius: 25, elevation: 12 },
  headerTop: { flexDirection: 'row', alignItems: 'center' },
  logoCircle: { width: 55, height: 55, borderRadius: 27.5, backgroundColor: '#fff', justifyContent: 'center', alignItems: 'center', elevation: 5 },
  logo: { width: 40, height: 45 },
  headerTxtWrapper: { flex: 1, marginLeft: 15 },
  subTitle: { fontSize: 8, color: '#2563eb', fontWeight: '900' },
  mainTitle: { fontSize: 17, fontWeight: '900', color: '#1e293b' },
  shareBtn: { width: 40, height: 40, borderRadius: 12, backgroundColor: '#f1f5f9', justifyContent: 'center', alignItems: 'center' },
  scrollContent: { padding: 20 },
  heroCard: { backgroundColor: '#fff', borderRadius: 25, overflow: 'hidden', elevation: 10, marginBottom: 25 },
  heroGradient: { padding: 25, paddingVertical: 30, position: 'relative' },
  heroBgIcon: { position: 'absolute', right: -10, bottom: -10 },
  heroTitle: { color: '#fff', fontSize: 18, fontWeight: '900', marginBottom: 5 },
  heroSubtitle: { color: 'rgba(255,255,255,0.8)', fontSize: 12, fontWeight: '600' },
  actionRow: { flexDirection: 'row', justifyContent: 'space-around', paddingVertical: 15 },
  actionItem: { alignItems: 'center', gap: 5 },
  actionIcon: { width: 44, height: 44, borderRadius: 22, justifyContent: 'center', alignItems: 'center' },
  actionLabel: { fontSize: 9, fontWeight: '800', color: '#64748b' },
  sectionCard: { backgroundColor: '#fff', borderRadius: 25, padding: 20, marginBottom: 20, elevation: 5 },
  sectionHeader: { flexDirection: 'row', alignItems: 'center', gap: 12, marginBottom: 15 },
  iconBox: { width: 36, height: 36, borderRadius: 10, backgroundColor: '#eff6ff', justifyContent: 'center', alignItems: 'center' },
  sectionTitle: { fontSize: 13, fontWeight: '900', color: '#1e293b', textTransform: 'uppercase' },
  visionText: { fontSize: 14, color: '#475569', lineHeight: 22, fontWeight: '600', fontStyle: 'italic', textAlign: 'center' },
  misiItem: { flexDirection: 'row', alignItems: 'flex-start', marginBottom: 10, gap: 10 },
  misiBullet: { width: 6, height: 6, borderRadius: 3, backgroundColor: '#2563eb', marginTop: 8 },
  misiText: { flex: 1, fontSize: 13, color: '#475569', lineHeight: 20, fontWeight: '600' },
  structureImg: { width: '100%', height: 250, marginTop: 5, borderRadius: 15 },
  emptyStructure: { height: 100, justifyContent: 'center', alignItems: 'center', backgroundColor: '#f8fafc', borderRadius: 15, borderStyle: 'dashed', borderWidth: 1, borderColor: '#cbd5e1' },
  emptyTxt: { fontSize: 11, color: '#94a3b8', fontWeight: '700' },
  socialCard: { alignItems: 'center', padding: 20, backgroundColor: '#fff', borderRadius: 25, marginBottom: 20, elevation: 3 },
  socialTitle: { fontSize: 11, fontWeight: '900', color: '#94a3b8', marginBottom: 15, textTransform: 'uppercase' },
  socialRow: { flexDirection: 'row', gap: 20 },
  socialBtn: { width: 48, height: 48, borderRadius: 24, backgroundColor: '#f8fafc', justifyContent: 'center', alignItems: 'center', borderWeight: 1, borderColor: '#eff6ff' },
  footerInfo: { alignItems: 'center', marginTop: 10 },
  footerTxt: { fontSize: 11, fontWeight: '900', color: '#cbd5e1' },
  footerVersion: { fontSize: 9, fontWeight: '700', color: '#e2e8f0', marginTop: 4 },
  center: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: '#fff' },
  loadingText: { marginTop: 15, fontSize: 12, color: '#64748b', fontWeight: '800' }
});
