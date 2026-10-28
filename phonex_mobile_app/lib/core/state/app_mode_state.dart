import 'package:flutter/foundation.dart';

enum AppMode {
  b2cCustomer, // Khách lẻ (Định giá, Mua Like New 99%, Trả góp, Tra cứu)
  b2bPartner,  // Đại lý & CTV (Thẩm định tại quầy, Mua sỉ theo lô, Ví hoa hồng)
}

class AppModeState extends ChangeNotifier {
  AppMode _currentMode = AppMode.b2cCustomer;
  
  // B2B Partner Details
  String _partnerCode = 'PX-VIP-8899';
  String _partnerName = 'Đại Lý PhoneX Sài Gòn 01';
  double _walletBalance = 14850000; // 14.850.000 VNĐ hoa hồng
  int _completedTickets = 38;
  bool _isPartnerLoggedIn = true;

  AppMode get currentMode => _currentMode;
  bool get isB2B => _currentMode == AppMode.b2bPartner;
  bool get isB2C => _currentMode == AppMode.b2cCustomer;

  String get partnerCode => _partnerCode;
  String get partnerName => _partnerName;
  double get walletBalance => _walletBalance;
  int get completedTickets => _completedTickets;
  bool get isPartnerLoggedIn => _isPartnerLoggedIn;

  void toggleMode() {
    _currentMode = (_currentMode == AppMode.b2cCustomer) 
        ? AppMode.b2bPartner 
        : AppMode.b2cCustomer;
    notifyListeners();
  }

  void switchToB2B() {
    if (_currentMode != AppMode.b2bPartner) {
      _currentMode = AppMode.b2bPartner;
      notifyListeners();
    }
  }

  void switchToB2C() {
    if (_currentMode != AppMode.b2cCustomer) {
      _currentMode = AppMode.b2cCustomer;
      notifyListeners();
    }
  }

  void addCommission(double amount) {
    _walletBalance += amount;
    _completedTickets += 1;
    notifyListeners();
  }
}
