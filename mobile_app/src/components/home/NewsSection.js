import React from 'react';
import { StyleSheet, Text, View, ScrollView, Image, TouchableOpacity, Linking } from 'react-native';
import { Calendar, Eye, Newspaper, ExternalLink } from 'lucide-react-native';
import { LinearGradient } from 'expo-linear-gradient';

export default function NewsSection({ news }) {
  if (!news || news.length === 0) return null;

  const getCleanImage = (item) => {
    let url = item.image || '';
    if (url && typeof url === 'string' && url.length > 10) {
        url = url.replace('http://', 'https://').trim();
        return { uri: url };
    }
    return { uri: 'https://ppidkab.sinjaikab.go.id/v2/storage/logo/ppid.webp' };
  };

  return (
    <View style={styles.container}>
      <View style={styles.header}>
        <View style={styles.titleGroup}>
            <Newspaper size={20} color="#2563eb" strokeWidth={2.5} />
            <Text style={styles.title}>Berita Humas</Text>
        </View>
        <TouchableOpacity 
            style={styles.seeAllBtn} 
            onPress={() => Linking.openURL('https://humas.sinjaikab.go.id')}
        >
            <Text style={styles.seeAll}>Lihat Semua</Text>
            <ExternalLink size={10} color="#2563eb" />
        </TouchableOpacity>
      </View>

      <ScrollView horizontal showsHorizontalScrollIndicator={false} contentContainerStyle={styles.scroll}>      
        {news.map((item, index) => (
          <TouchableOpacity
            key={index}
            style={styles.card}
            activeOpacity={0.9}
            onPress={() => item.link && Linking.openURL(item.link)}
          >
            <View style={styles.imageWrapper}>
                <Image
                    source={getCleanImage(item)}
                    style={styles.image}
                    resizeMode="cover"
                />
                <LinearGradient
                    colors={['transparent', 'rgba(0,0,0,0.6)']}
                    style={styles.imageOverlay}
                />
            </View>

            <View style={styles.content}>
              <Text style={styles.newsTitle} numberOfLines={2}>{item.title}</Text>
              
              <View style={styles.divider} />

              <View style={styles.footer}>
                <View style={styles.footerItem}>
                    <Calendar size={12} color="#94a3b8" />
                    <Text style={styles.footerText}>{item.pubDate}</Text>
                </View>
                <View style={[styles.footerItem, styles.viewBadge]}>
                    <Eye size={10} color="#fff" />
                    <Text style={styles.viewText}>{item.views}</Text>
                </View>
              </View>
            </View>
          </TouchableOpacity>
        ))}
        <View style={{ width: 25 }} />
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { marginTop: 35 },
  header: { 
    paddingHorizontal: 25, 
    marginBottom: 18, 
    flexDirection: 'row', 
    justifyContent: 'space-between', 
    alignItems: 'center' 
  },
  titleGroup: { flexDirection: 'row', alignItems: 'center', gap: 10 },
  title: { fontSize: 18, fontWeight: '900', color: '#1e293b' },
  seeAllBtn: { flexDirection: 'row', alignItems: 'center', gap: 5, backgroundColor: '#eff6ff', paddingHorizontal: 12, paddingVertical: 6, borderRadius: 12 },
  seeAll: { fontSize: 10, color: '#2563eb', fontWeight: '900' },
  
  scroll: { paddingLeft: 25 },
  card: {
    width: 260,
    backgroundColor: '#fff',
    borderRadius: 30,
    marginRight: 20,
    overflow: 'hidden',
    borderWidth: 1,
    borderColor: '#f1f5f9',
    elevation: 10,
    shadowColor: '#1e293b',
    shadowOpacity: 0.1,
    shadowRadius: 15
  },
  imageWrapper: { width: '100%', height: 140, backgroundColor: '#f8fafc', position: 'relative' },
  image: { width: '100%', height: '100%' },
  imageOverlay: { position: 'absolute', bottom: 0, left: 0, right: 0, height: 40 },
  
  content: { padding: 18 },
  newsTitle: { fontSize: 13, fontWeight: '800', color: '#1e293b', lineHeight: 20, height: 40 },
  
  divider: { height: 1, backgroundColor: '#f1f5f9', marginVertical: 12 },
  
  footer: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center' },       
  footerItem: { flexDirection: 'row', alignItems: 'center', gap: 6 },
  footerText: { fontSize: 10, color: '#94a3b8', fontWeight: '800' },
  
  viewBadge: { backgroundColor: '#1e293b', paddingHorizontal: 8, paddingVertical: 4, borderRadius: 8 },
  viewText: { fontSize: 9, color: '#fff', fontWeight: '900' }
});
