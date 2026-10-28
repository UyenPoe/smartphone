import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../core/constants/app_colors.dart';
import '../core/state/app_mode_state.dart';
import 'widgets/dual_mode_header.dart';
import 'features/b2c/home_screen.dart';
import 'features/b2c/price_list_screen.dart';
import 'features/b2c/valuation_screen.dart';
import 'features/b2c/used_phones_screen.dart';
import 'features/b2c/tracking_screen.dart';
import 'features/b2b/wholesale_screen.dart';
import 'features/b2b/store_diagnostic_screen.dart';
import 'features/b2b/partner_wallet_screen.dart';

class MainNavigationScreen extends StatefulWidget {
  const MainNavigationScreen({super.key});

  @override
  State<MainNavigationScreen> createState() => _MainNavigationScreenState();
}

class _MainNavigationScreenState extends State<MainNavigationScreen> {
  int _b2cIndex = 0;
  int _b2bIndex = 0;

  @override
  Widget build(BuildContext context) {
    final modeState = context.watch<AppModeState>();
    final isB2B = modeState.isB2B;

    return Scaffold(
      appBar: const DualModeHeader(),
      body: isB2B ? _buildB2BBody() : _buildB2CBody(),
      bottomNavigationBar: isB2B ? _buildB2BBottomBar() : _buildB2CBottomBar(),
    );
  }

  // B2C Customer Screens
  Widget _buildB2CBody() {
    return IndexedStack(
      index: _b2cIndex,
      children: [
        B2CHomeScreen(onTabChange: (idx) => setState(() => _b2cIndex = idx)),
        B2CPriceListScreen(onNavigateToValuation: (idx) => setState(() => _b2cIndex = idx)),
        const B2CValuationScreen(),
        const B2CUsedPhonesScreen(),
        const B2CTrackingScreen(),
      ],
    );
  }

  // B2B Partner Screens
  Widget _buildB2BBody() {
    return IndexedStack(
      index: _b2bIndex,
      children: const [
        B2BWholesaleScreen(),
        B2BStoreDiagnosticScreen(),
        B2BPartnerWalletScreen(),
      ],
    );
  }

  // B2C Navigation Bar
  Widget _buildB2CBottomBar() {
    return NavigationBar(
      selectedIndex: _b2cIndex,
      onDestinationSelected: (idx) => setState(() => _b2cIndex = idx),
      indicatorColor: AppColors.primaryContainer,
      backgroundColor: Colors.white,
      elevation: 8,
      destinations: const [
        NavigationDestination(
          icon: Icon(Icons.home_outlined),
          selectedIcon: Icon(Icons.home, color: AppColors.primary),
          label: 'Trang chủ',
        ),
        NavigationDestination(
          icon: Icon(Icons.table_chart_outlined),
          selectedIcon: Icon(Icons.table_chart, color: AppColors.primary),
          label: 'Bảng giá',
        ),
        NavigationDestination(
          icon: Icon(Icons.calculate_outlined),
          selectedIcon: Icon(Icons.calculate, color: AppColors.primary),
          label: 'Định giá 30s',
        ),
        NavigationDestination(
          icon: Icon(Icons.inventory_2_outlined),
          selectedIcon: Icon(Icons.inventory_2, color: AppColors.primary),
          label: 'Kho máy cũ',
        ),
        NavigationDestination(
          icon: Icon(Icons.track_changes_outlined),
          selectedIcon: Icon(Icons.track_changes, color: AppColors.primary),
          label: 'Tra cứu',
        ),
      ],
    );
  }

  // B2B Navigation Bar
  Widget _buildB2BBottomBar() {
    return NavigationBar(
      selectedIndex: _b2bIndex,
      onDestinationSelected: (idx) => setState(() => _b2bIndex = idx),
      indicatorColor: AppColors.b2bAccent.withOpacity(0.2),
      backgroundColor: AppColors.b2bPrimary,
      elevation: 8,
      destinations: const [
        NavigationDestination(
          icon: Icon(Icons.storefront_outlined, color: Colors.white70),
          selectedIcon: Icon(Icons.storefront, color: AppColors.b2bAccent),
          label: 'Kho Sỉ B2B',
        ),
        NavigationDestination(
          icon: Icon(Icons.precision_manufacturing_outlined, color: Colors.white70),
          selectedIcon: Icon(Icons.precision_manufacturing, color: AppColors.b2bAccent),
          label: 'Test tại quầy',
        ),
        NavigationDestination(
          icon: Icon(Icons.account_balance_wallet_outlined, color: Colors.white70),
          selectedIcon: Icon(Icons.account_balance_wallet, color: AppColors.b2bAccent),
          label: 'Ví hoa hồng',
        ),
      ],
    );
  }
}
