import React, { useEffect, useRef, useState, memo } from 'react';
import { StyleSheet, Text, View, Animated, Easing, Dimensions } from 'react-native';
import { MessageSquare, Star, User } from 'lucide-react-native';
import { LinearGradient } from 'expo-linear-gradient';

const { width: SCREEN_WIDTH } = Dimensions.get('window');

// 1. WADAH KECIL: Satu ulasan lengkap (Nama + Teks + Bintang)
const WadahKecil = memo(({ item, id }) => (
  <View style={styles.wadahKecil}>
    <User size={12} color="#60a5fa" strokeWidth={2.5} />
    <Text style={styles.namaText}>{item.nama_pemohon}:</Text>
    
    <Text style={styles.ulasanText} numberOfLines={1}>
      "{item.text}"
    </Text>

    <View style={styles.bintangRow}>
      {[...Array(Math.floor(item.rating || 5))].map((_, i) => (
        <Star key={`s-${id}-${i}`} size={10} color="#fbbf24" fill="#fbbf24" />
      ))}
    </View>

    <View style={{ width: 80 }} />
  </View>
));

// 2. WADAH BESAR: Rel panjang yang berisi semua ulasan
const WadahBesar = ({ data, onLayout, prefix }) => (
  <View 
    style={styles.wadahBesar} 
    onLayout={onLayout}
  >
    {data.map((item, index) => (
      <WadahKecil 
        key={`${prefix}-${index}`} 
        item={item} 
        id={`${prefix}-${index}`} 
      />
    ))}
    <View style={{ width: 150 }} />
  </View>
);

export default function RunningTicker({ ticker }) {
  const scrollX = useRef(new Animated.Value(0)).current;
  const [trackWidth, setTrackWidth] = useState(0);

  if (!ticker || ticker.length === 0) return null;

  useEffect(() => {
    if (trackWidth > 0) {
      const startRunning = () => {
        scrollX.setValue(0);
        const duration = trackWidth * 35; 

        Animated.loop(
          Animated.timing(scrollX, {
            toValue: -trackWidth,
            duration: duration,
            easing: Easing.linear,
            useNativeDriver: true,
          })
        ).start();
      };
      startRunning();
    }
  }, [trackWidth, ticker.length]);

  return (
    <LinearGradient colors={['#1e293b', '#0f172a']} style={styles.container}>
      <View style={styles.label}>
        <MessageSquare size={10} color="#fff" strokeWidth={3} />
        <Text style={styles.labelText}>ULASAN</Text>
      </View>

      <View style={styles.viewport}>
        <Animated.View
          style={[styles.animator, { transform: [{ translateX: scrollX }] }]}
        >
          <WadahBesar 
            prefix="A" 
            data={ticker} 
            onLayout={(e) => setTrackWidth(e.nativeEvent.layout.width)} 
          />
          <WadahBesar 
            prefix="B" 
            data={ticker} 
          />
        </Animated.View>
      </View>
    </LinearGradient>
  );
}

const styles = StyleSheet.create({
  container: { marginVertical: 15, paddingVertical: 12, flexDirection: 'row', alignItems: 'center', overflow: 'hidden' },
  label: {
    backgroundColor: '#2563eb', paddingHorizontal: 12, paddingVertical: 6,
    borderRadius: 20, flexDirection: 'row', alignItems: 'center', gap: 5,
    marginLeft: 15, marginRight: 15, elevation: 10, zIndex: 100
  },
  labelText: { color: '#fff', fontSize: 9, fontWeight: '900' },
  viewport: { flex: 1, overflow: 'hidden' },
  animator: { flexDirection: 'row', alignItems: 'center' },
  wadahBesar: { flexDirection: 'row', alignItems: 'center' },
  wadahKecil: { flexDirection: 'row', alignItems: 'center', gap: 10, flexShrink: 0 },
  namaText: { color: '#fff', fontSize: 11, fontWeight: '900' },
  ulasanText: { color: 'rgba(255,255,255,0.8)', fontSize: 11, fontWeight: '600', fontStyle: 'italic' },
  bintangRow: { flexDirection: 'row', gap: 2, alignItems: 'center' }
});
