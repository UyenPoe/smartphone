import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:provider/provider.dart';
import '../../../core/constants/app_colors.dart';
import '../../../core/state/app_mode_state.dart';

class B2BStoreDiagnosticScreen extends StatefulWidget {
  const B2BStoreDiagnosticScreen({super.key});

  @override
  State<B2BStoreDiagnosticScreen> createState() => _B2BStoreDiagnosticScreenState();
}

class _B2BStoreDiagnosticScreenState extends State<B2BStoreDiagnosticScreen> {
  final NumberFormat _currencyFormat = NumberFormat('#,###', 'vi_VN');

  String _selectedModel = 'iPhone 15 Pro Max 256GB';
  bool _screenOk = true;
  bool _touchOk = true;
  bool _faceIdOk = true;
  bool _cameraOk = true;
  bool _batteryOk = true;
  bool _bodyOk = true;

  double _calculatedBuyPrice = 21500000;
  double _partnerCommission = 860000; // 4% hoa hồng đại lý

  void _recalc() {
    double price = 21500000;
    if (!_screenOk) price -= 2500000;
    if (!_touchOk) price -= 1200000;
    if (!_faceIdOk) price -= 1800000;
    if (!_cameraOk) price -= 1500000;
    if (!_batteryOk) price -= 800000;
    if (!_bodyOk) price -= 1000000;

    setState(() {
      _calculatedBuyPrice = price > 5000000 ? price : 5000000;
      _partnerCommission = _calculatedBuyPrice * 0.04;
    });
  }

  @override
  Widget build(BuildContext context) {
    final modeState = context.watch<AppModeState>();

    return Scaffold(
      backgroundColor: const Color(0xFFF1F5F9),
      appBar: AppBar(
        backgroundColor: AppColors.b2bPrimary,
        title: const Text('Thẩm Định Máy Tại Quầy (Dành Cho KTV)', style: TextStyle(color: Colors.white, fontSize: 15)),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Model Selector Card
            Container(
              padding: const EdgeInsets.all(14),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(14),
                border: Border.all(color: const Color(0xFFE2E8F0)),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text('Thiết bị khách mang đến quầy:', style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.grey)),
                  const SizedBox(height: 6),
                  DropdownButtonFormField<String>(
                    value: _selectedModel,
                    decoration: const InputDecoration(contentPadding: EdgeInsets.symmetric(horizontal: 12, vertical: 8)),
                    items: const [
                      DropdownMenuItem(value: 'iPhone 15 Pro Max 256GB', child: Text('iPhone 15 Pro Max 256GB')),
                      DropdownMenuItem(value: 'iPhone 14 Pro Max 128GB', child: Text('iPhone 14 Pro Max 128GB')),
                      DropdownMenuItem(value: 'Galaxy S24 Ultra 256GB', child: Text('Galaxy S24 Ultra 256GB')),
                    ],
                    onChanged: (v) {
                      if (v != null) setState(() => _selectedModel = v);
                    },
                  ),
                ],
              ),
            ),

            const SizedBox(height: 16),

            // Diagnostic 6-Checklist
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(16),
                border: Border.all(color: const Color(0xFFE2E8F0)),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text('Khảo sát nhanh 6 hạng mục kỹ thuật:', style: TextStyle(fontSize: 14, fontWeight: FontWeight.w900)),
                  const SizedBox(height: 10),
                  _buildCheckItem('1. Màn hình hiển thị (Không sọc / không ám)', _screenOk, (v) { setState(() => _screenOk = v); _recalc(); }),
                  _buildCheckItem('2. Cảm ứng vuốt mượt mà 100%', _touchOk, (v) { setState(() => _touchOk = v); _recalc(); }),
                  _buildCheckItem('3. Face ID / Vân tay hoạt động tốt', _faceIdOk, (v) { setState(() => _faceIdOk = v); _recalc(); }),
                  _buildCheckItem('4. Cụm Camera trước / sau nét', _cameraOk, (v) { setState(() => _cameraOk = v); _recalc(); }),
                  _buildCheckItem('5. Pin trên 85% dung lượng thực', _batteryOk, (v) { setState(() => _batteryOk = v); _recalc(); }),
                  _buildCheckItem('6. Vỏ & sườn không cấn móp nặng', _bodyOk, (v) { setState(() => _bodyOk = v); _recalc(); }),
                ],
              ),
            ),

            const SizedBox(height: 16),

            // Guaranteed Price & Commission Card
            Container(
              padding: const EdgeInsets.all(18),
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [Color(0xFF0F172A), Color(0xFF1E293B)],
                ),
                borderRadius: BorderRadius.circular(16),
                border: Border.all(color: AppColors.b2bAccent),
              ),
              child: Column(
                children: [
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      const Text('PhoneX Cam Kết Thu:', style: TextStyle(color: Colors.white70, fontSize: 13)),
                      Text(
                        '${_currencyFormat.format(_calculatedBuyPrice)}đ',
                        style: const TextStyle(color: Colors.white, fontWeight: FontWeight.w900, fontSize: 18),
                      ),
                    ],
                  ),
                  const Divider(color: Colors.white24, height: 20),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      const Row(
                        children: [
                          Icon(Icons.monetization_on, color: AppColors.b2bAccent, size: 18),
                          SizedBox(width: 6),
                          Text('Hoa hồng đại lý nhận ngay:', style: TextStyle(color: AppColors.b2bAccent, fontWeight: FontWeight.w900, fontSize: 13)),
                        ],
                      ),
                      Text(
                        '+${_currencyFormat.format(_partnerCommission)}đ',
                        style: const TextStyle(color: AppColors.b2bAccent, fontWeight: FontWeight.w900, fontSize: 18),
                      ),
                    ],
                  ),
                  const SizedBox(height: 14),
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton(
                      onPressed: () {
                        modeState.addCommission(_partnerCommission);
                        ScaffoldMessenger.of(context).showSnackBar(
                          SnackBar(
                            content: Text('🎉 Đã chốt phiếu thu tại quầy! +${_currencyFormat.format(_partnerCommission)}đ đã được cộng vào Ví đối tác.'),
                            backgroundColor: Colors.green,
                          ),
                        );
                      },
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppColors.b2bAccent,
                        foregroundColor: Colors.black,
                      ),
                      child: const Text('CHỐT THU MÁY & IN PHIẾU QR CHO KHÁCH'),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildCheckItem(String label, bool value, Function(bool) onChanged) {
    return SwitchListTile(
      value: value,
      onChanged: (v) => onChanged(v),
      title: Text(label, style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w600)),
      dense: true,
      activeColor: AppColors.b2bAccent,
      contentPadding: EdgeInsets.zero,
    );
  }
}
