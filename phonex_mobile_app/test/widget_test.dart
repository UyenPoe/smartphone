import 'package:flutter_test/flutter_test.dart';
import 'package:provider/provider.dart';
import 'package:phonex_mobile_app/core/state/app_mode_state.dart';
import 'package:phonex_mobile_app/main.dart';

void main() {
  testWidgets('PhoneX smoke test', (WidgetTester tester) async {
    await tester.pumpWidget(
      MultiProvider(
        providers: [
          ChangeNotifierProvider(create: (_) => AppModeState()),
        ],
        child: const PhoneXMobileApp(),
      ),
    );

    expect(find.byType(PhoneXMobileApp), findsOneWidget);
  });
}
