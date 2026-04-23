import React, { useEffect, useState } from 'react';
import { 
  StyleSheet, View, ScrollView, ActivityIndicator, StatusBar, RefreshControl, Text, TouchableOpacity, Image
} from 'react-native';
import { Accessibility } from 'lucide-react-native';
import { API_ENDPOINTS } from '../api/config';

// Import Modular Components
import PremiumSlider from '../components/home/PremiumSlider';
import LayananGrid from '../components/home/LayananGrid';
import LatestDocs from '../components/home/LatestDocs';
import NewsSection from '../components/home/NewsSection';
import StatsSection from '../components/home/StatsSection';
import GallerySection from '../components/home/GallerySection';
import RunningTicker from '../components/home/RunningTicker';

const STATUSBAR_HEIGHT = StatusBar.currentHeight || 0;

export default function HomeScreen() {
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const [data, setData] = useState(null);

  useEffect(() => {
    fetchHomeData();
  }, []);

  const fetchHomeData = async () => {
    try {
      const response = await fetch(API_ENDPOINTS.HOME);
      const json = await response.json();
      if (json.success) setData(json.data);
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  if (loading || !data) {
    return (
      <View style={styles.loader}>
        <ActivityIndicator size="large" color="#2563eb" />
        <Text style={styles.loaderText}>PPID KABUPATEN SINJAI</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="transparent" translucent={true} />

      {/* HEADER PREMIUM BULAT SESUAI PERMINTAAN */}
      <View style={[styles.headerSection, { paddingTop: STATUSBAR_HEIGHT + 10 }]}>
          <View style={styles.headerTop}>
            <View style={styles.logoCircle}>
                <Image 
                    source={require('../../assets/icon.webp')} 
                    style={styles.logo} 
                    resizeMode="contain" 
                />
            </View>
            <View style={styles.headerTxtWrapper}>
              <Text style={styles.subTitle}>APLIKASI RESMI</Text>
              <Text style={styles.mainTitle}>PPID Kab. Sinjai</Text>
            </View>
            <TouchableOpacity style={styles.headerActionBtn}>
                <Accessibility size={24} color="#2563eb" strokeWidth={2.5} />
            </TouchableOpacity>
          </View>
      </View>

      <ScrollView
        showsVerticalScrollIndicator={false}
        contentContainerStyle={styles.scrollContent}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={() => {setRefreshing(true); fetchHomeData();}} colors={['#2563eb']} />}
      >
        <PremiumSlider sliders={data.sliders} />
        <LayananGrid />
        <LatestDocs docs={data.latest_informasi} />
        <NewsSection news={data.news} />

        <StatsSection stats={data.statistics} />

        <RunningTicker ticker={data.ticker} />

        <GallerySection gallery={data.gallery} />

        <View style={{height: 120}} />
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f4f7fa' },
  loader: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: '#fff' },
  loaderText: { marginTop: 15, fontSize: 10, fontWeight: '900', color: '#94a3b8', letterSpacing: 2 },
  
  // Design Header Bulat Konsisten
  headerSection: { backgroundColor: '#fff', paddingHorizontal: 20, paddingBottom: 10, borderBottomLeftRadius: 25, borderBottomRightRadius: 25, elevation: 12, shadowColor: '#1e293b', shadowOpacity: 0.1, shadowRadius: 15 },
  headerTop: { flexDirection: 'row', alignItems: 'center' },
  logoCircle: { width: 55, height: 55, borderRadius: 27.5, backgroundColor: '#fff', justifyContent: 'center', alignItems: 'center', elevation: 5, shadowColor: '#000', shadowOpacity: 0.1, shadowRadius: 5, borderWidth: 1, borderColor: '#f1f5f9' },
  logo: { width: 40, height: 45 },
  headerTxtWrapper: { flex: 1, marginLeft: 15 },
  subTitle: { fontSize: 8, color: '#2563eb', fontWeight: '900', letterSpacing: 0.5 },
  mainTitle: { fontSize: 17, fontWeight: '900', color: '#1e293b' },
  headerActionBtn: { width: 40, height: 40, borderRadius: 12, backgroundColor: '#f8fafc', justifyContent: 'center', alignItems: 'center', borderWidth: 1, borderColor: '#eff6ff' },
  
  scrollContent: { paddingBottom: 50 },
});
