import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../core/constants/app_colors.dart';
import '../../core/state/app_mode_state.dart';

class DualModeHeader extends StatelessWidget implements PreferredSizeWidget {
  final VoidCallback? onSearchTap;

  const DualModeHeader({super.key, this.onSearchTap});

  @override
  Size get preferredSize => const Size.fromHeight(64);

  @override
  Widget build(BuildContext context) {
    final modeState = context.watch<AppModeState>();
    final isB2B = modeState.isB2B;

    return Container(
      color: isB2B ? AppColors.b2bPrimary : Colors.white,
      padding: EdgeInsets.only(
        top: MediaQuery.of(context).padding.top + 6,
        left: 16,
        right: 16,
        bottom: 8,
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.between,
        children: [
          // Left: Brand Logo & Mode Badge
          Row(
            children: [
              Container(
                width: 36,
                height: 36,
                decoration: BoxDecoration(
                  color: isB2B ? AppColors.b2bAccent : AppColors.primary,
                  borderRadius: BorderRadius.circular(10),
                ),
                child: const Icon(
                  Icons.smartphone,
                  color: Colors.white,
                  size: 20,
                ),
              ),
              const SizedBox(width: 8),
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisSize: MainAxisSize.min,
                children: [
                  RichText(
                    text: TextSpan(
                      text: 'Phone',
                      style: TextStyle(
                        color: isB2B ? Colors.white : AppColors.textPrimary,
                        fontSize: 20,
                        fontWeight: FontWeight.w900,
                        letterSpacing: -0.5,
                      ),
                      children: [
                        TextSpan(
                          text: 'X',
                          style: TextStyle(
                            color: isB2B ? AppColors.b2bAccent : AppColors.primary,
                          ),
                        ),
                      ],
                    ),
                  ),
                  Text(
                    isB2B ? 'CỔNG ĐẠI LÝ & SỈ B2B' : 'Thu Mua & Bán Sỉ',
                    style: TextStyle(
                      color: isB2B ? const Color(0xFF94A3B8) : AppColors.textSecondary,
                      fontSize: 9.5,
                      fontWeight: FontWeight.w700,
                      letterSpacing: 0.5,
                    ),
                  ),
                ],
              ),
            ],
          ),

          // Right: Dual-Mode Switcher Button
          GestureDetector(
            onTap: () {
              modeState.toggleMode();
              ScaffoldMessenger.of(context).showSnackBar(
                SnackBar(
                  content: Text(
                    modeState.isB2B
                        ? '🚀 Đã chuyển sang Chế độ Đại Lý & Bán Sỉ B2B'
                        : '🛍️ Đã chuyển về Chế độ Khách Lẻ B2C',
                  ),
                  duration: const Duration(seconds: 2),
                  backgroundColor: modeState.isB2B ? AppColors.b2bPrimary : AppColors.primary,
                  behavior: SnackBarBehavior.floating,
                ),
              );
            },
            child: AnimatedContainer(
              duration: const Duration(milliseconds: 300),
              padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
              decoration: BoxDecoration(
                color: isB2B ? AppColors.b2bAccent.withOpacity(0.2) : AppColors.primaryContainer,
                borderRadius: BorderRadius.circular(20),
                border: Border.all(
                  color: isB2B ? AppColors.b2bAccent : AppColors.primary.withOpacity(0.3),
                  width: 1.2,
                ),
              ),
              child: Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Icon(
                    isB2B ? Icons.storefront : Icons.handshake_outlined,
                    size: 15,
                    color: isB2B ? AppColors.b2bAccent : AppColors.primaryDark,
                  ),
                  const SizedBox(width: 5),
                  Text(
                    isB2B ? 'ĐẠI LÝ B2B' : 'Cổng Đại Lý',
                    style: TextStyle(
                      fontSize: 11,
                      fontWeight: FontWeight.w800,
                      color: isB2B ? AppColors.b2bAccent : AppColors.primaryDark,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
