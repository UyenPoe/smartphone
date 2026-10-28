import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'core/theme/app_theme.dart';
import 'core/state/app_mode_state.dart';
import 'ui/main_navigation_screen.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  runApp(
    MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => AppModeState()),
      ],
      child: const PhoneXMobileApp(),
    ),
  );
}

class PhoneXMobileApp extends StatelessWidget {
  const PhoneXMobileApp({super.key});

  @override
  Widget build(BuildContext context) {
    final modeState = context.watch<AppModeState>();

    return MaterialApp(
      title: 'PhoneX Mobile - Thu Mua & Bán Sỉ',
      debugShowCheckedModeBanner: false,
      theme: modeState.isB2B ? AppTheme.b2bTheme : AppTheme.lightTheme,
      home: const MainNavigationScreen(),
    );
  }
}
