import 'react-native-gesture-handler';
import "./global.css";
import React, { useState, useEffect } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { LayoutGrid, FileText, Users, Building2, Plus } from 'lucide-react-native';
import { View, Text, StyleSheet, Platform, TouchableOpacity, Image, ActivityIndicator, StatusBar } from 'react-native';
import { LinearGradient } from 'expo-linear-gradient';

// Import Screens
import HomeScreen from './src/screens/HomeScreen';
import InformasiScreen from './src/screens/InformasiScreen';
import PejabatScreen from './src/screens/PejabatScreen';
import PermohonanScreen from './src/screens/PermohonanScreen';
import ProfilScreen from './src/screens/ProfilScreen';

const Tab = createBottomTabNavigator();

const SplashScreen = () => (
    <LinearGradient colors={['#1e293b', '#0f172a']} style={styles.splashContainer}>
      <StatusBar barStyle="light-content" />
      <View style={styles.splashContent}>
        <Image source={require('./assets/icon.webp')} style={styles.splashLogo} resizeMode="contain" />
        <Text style={styles.splashTitle}>PPID</Text>
        <Text style={styles.splashSubtitle}>KABUPATEN SINJAI</Text>
        <View style={styles.splashDivider} />
        <Text style={styles.splashDesc}>Pejabat Pengelola Informasi{"\n"}dan Dokumentasi</Text>
        <View style={styles.splashLoader}>
            <ActivityIndicator size="small" color="#60a5fa" />
            <Text style={styles.loadingText}>Memuat Aplikasi...</Text>
        </View>
      </View>
    </LinearGradient>
);

const CustomActionTabButton = ({ onPress }) => (
  <TouchableOpacity style={styles.customTabContainer} onPress={onPress} activeOpacity={0.9}>
    <View style={styles.customTabCircle}>
      <Plus size={32} color="#fff" strokeWidth={3} />
    </View>
  </TouchableOpacity>
);

export default function App() {
  const [isAppReady, setIsAppAppReady] = useState(false);

  useEffect(() => {
    setTimeout(() => setIsAppAppReady(true), 2000);
  }, []);

  if (!isAppReady) return <SplashScreen />;

  return (
    <NavigationContainer>
      <Tab.Navigator
        screenOptions={({ route }) => ({
          tabBarIcon: ({ focused, color }) => {
            const size = 22;
            const strokeWidth = focused ? 2.5 : 2;
            if (route.name === 'Beranda') return <LayoutGrid size={size} color={color} strokeWidth={strokeWidth} />;
            if (route.name === 'Dokumen') return <FileText size={size} color={color} strokeWidth={strokeWidth} />;
            if (route.name === 'Pejabat') return <Users size={size} color={color} strokeWidth={strokeWidth} />;
            if (route.name === 'Profil') return <Building2 size={size} color={color} strokeWidth={strokeWidth} />;
            return null;
          },
          tabBarActiveTintColor: '#2563eb',
          tabBarInactiveTintColor: '#94a3b8',
          tabBarStyle: styles.tabBar,
          tabBarLabelStyle: styles.tabBarLabel,
          headerShown: false
        })}
      >
        <Tab.Screen name="Beranda" component={HomeScreen} />
        <Tab.Screen name="Dokumen" component={InformasiScreen} />
        <Tab.Screen 
          name="Permohonan" 
          component={PermohonanScreen}
          options={{ tabBarButton: (props) => <CustomActionTabButton {...props} /> }}
        />
        <Tab.Screen name="Pejabat" component={PejabatScreen} />
        <Tab.Screen name="Profil" component={ProfilScreen} />
      </Tab.Navigator>
    </NavigationContainer>
  );
}

const styles = StyleSheet.create({
  splashContainer: { flex: 1, justifyContent: 'center', alignItems: 'center' },
  splashContent: { alignItems: 'center', padding: 40 },
  splashLogo: { width: 150, height: 150, marginBottom: 20 },
  splashTitle: { fontSize: 32, fontWeight: '900', color: '#fff', letterSpacing: 3 },
  splashSubtitle: { fontSize: 14, fontWeight: '800', color: '#60a5fa', marginTop: 5 },
  splashDivider: { width: 50, height: 3, backgroundColor: '#2563eb', marginVertical: 20 },
  splashDesc: { fontSize: 10, color: 'rgba(255,255,255,0.5)', fontWeight: '900', textAlign: 'center', textTransform: 'uppercase', lineHeight: 16 },
  splashLoader: { marginTop: 40, alignItems: 'center', gap: 10 },
  loadingText: { fontSize: 9, color: '#64748b', fontWeight: '800' },
  tabBar: { position: 'absolute', bottom: 25, left: 20, right: 20, backgroundColor: '#ffffff', borderRadius: 30, height: 70, borderTopWidth: 0, elevation: 15 },
  tabBarLabel: { fontSize: 9, fontWeight: '800', marginBottom: 5, textTransform: 'uppercase' },
  customTabContainer: { top: -28, justifyContent: 'center', alignItems: 'center' },
  customTabCircle: { width: 60, height: 60, borderRadius: 30, backgroundColor: '#2563eb', justifyContent: 'center', alignItems: 'center', elevation: 10, borderWidth: 5, borderColor: '#fcfcfc' }
});