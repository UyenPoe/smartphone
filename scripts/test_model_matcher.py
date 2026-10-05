import re

def detect_model_key(title):
    t = title
    t = re.sub(r'\[Grade [^\]]+\]', '', t)
    t = re.sub(r'^(Apple|Samsung|Xiaomi)\s+', '', t, flags=re.I)
    
    # Extract capacity if present
    cap_m = re.search(r'\b(2TB|1TB|512GB|256GB|128GB|64GB|32GB|16GB|512G|256G|128G)\b', t, re.I)
    capacity = cap_m.group(1).upper() if cap_m else "128GB"
    if capacity.endswith('G') and not capacity.endswith('GB'):
        capacity += 'B'

    # Extract RAM if present (e.g. 8GB/256GB or 12GB 512GB)
    ram_m = re.search(r'\b(\d+)\s*(?:GB|G)\s*(?:/|\s+)\s*(?:2TB|1TB|\d+\s*(?:GB|G))', t, re.I)
    ram = (ram_m.group(1) + " GB") if ram_m else None

    # Normalization for model key
    t_clean = t.lower()
    
    # Apple
    if 'iphone 17 pro max' in t_clean: return 'iphone_17_pro_max', capacity, ram or '12 GB'
    if 'iphone 17 pro' in t_clean: return 'iphone_17_pro', capacity, ram or '12 GB'
    if 'iphone air' in t_clean: return 'iphone_air', capacity, ram or '8 GB'
    if 'iphone 17' in t_clean: return 'iphone_17', capacity, ram or '8 GB'
    if 'iphone 16 pro max' in t_clean: return 'iphone_16_pro_max', capacity, ram or '8 GB'
    if 'iphone 16 pro' in t_clean: return 'iphone_16_pro', capacity, ram or '8 GB'
    if 'iphone 16 plus' in t_clean: return 'iphone_16_plus', capacity, ram or '8 GB'
    if 'iphone 16e' in t_clean: return 'iphone_16e', capacity, ram or '8 GB'
    if 'iphone 16' in t_clean: return 'iphone_16', capacity, ram or '8 GB'
    if 'iphone 15 pro max' in t_clean: return 'iphone_15_pro_max', capacity, ram or '8 GB'
    if 'iphone 15 pro' in t_clean: return 'iphone_15_pro', capacity, ram or '8 GB'
    if 'iphone 15 plus' in t_clean: return 'iphone_15_plus', capacity, ram or '6 GB'
    if 'iphone 15' in t_clean: return 'iphone_15', capacity, ram or '6 GB'
    if 'iphone 14 pro max' in t_clean: return 'iphone_14_pro_max', capacity, ram or '6 GB'
    if 'iphone 14 pro' in t_clean: return 'iphone_14_pro', capacity, ram or '6 GB'
    if 'iphone 14 plus' in t_clean: return 'iphone_14_plus', capacity, ram or '6 GB'
    if 'iphone 14' in t_clean: return 'iphone_14', capacity, ram or '6 GB'
    if 'iphone 13 pro max' in t_clean: return 'iphone_13_pro_max', capacity, ram or '6 GB'
    if 'iphone 12 mini' in t_clean: return 'iphone_12_mini', capacity, ram or '4 GB'
    if 'iphone 11' in t_clean: return 'iphone_11', capacity, ram or '4 GB'
    if 'iphone xs' in t_clean: return 'iphone_xs', capacity, ram or '4 GB'
    if 'iphone x' in t_clean: return 'iphone_x', capacity, ram or '3 GB'
    if 'se 2022' in t_clean: return 'iphone_se_2022', capacity, ram or '4 GB'
    if 'se 2020' in t_clean: return 'iphone_se_2020', capacity, ram or '3 GB'
    if 'iphone 8 plus' in t_clean: return 'iphone_8_plus', capacity, ram or '3 GB'
    if 'iphone 8' in t_clean: return 'iphone_8', capacity, ram or '2 GB'

    # Samsung
    if 's26 ultra' in t_clean: return 'samsung_s26_ultra', capacity, ram or '16 GB'
    if 's26 plus' in t_clean or 's26+' in t_clean: return 'samsung_s26_plus', capacity, ram or '12 GB'
    if 's26' in t_clean: return 'samsung_s26', capacity, ram or '12 GB'
    if 's25 ultra' in t_clean: return 'samsung_s25_ultra', capacity, ram or '12 GB'
    if 'z fold8 ultra' in t_clean: return 'samsung_z_fold8_ultra', capacity, ram or '16 GB'
    if 'z fold8' in t_clean: return 'samsung_z_fold8', capacity, ram or '12 GB'
    if 'z fold7' in t_clean: return 'samsung_z_fold7', capacity, ram or '12 GB'
    if 'z fold6' in t_clean: return 'samsung_z_fold6', capacity, ram or '12 GB'
    if 'z flip8' in t_clean: return 'samsung_z_flip8', capacity, ram or '12 GB'
    if 'z flip7' in t_clean: return 'samsung_z_flip7', capacity, ram or '8 GB'
    if 'a73' in t_clean: return 'samsung_a73', capacity, ram or '8 GB'
    if 'a72' in t_clean: return 'samsung_a72', capacity, ram or '8 GB'
    if 'a71 5g' in t_clean: return 'samsung_a71_5g', capacity, ram or '8 GB'
    if 'a71' in t_clean: return 'samsung_a71', capacity, ram or '8 GB'
    if 'a70' in t_clean: return 'samsung_a70', capacity, ram or '6 GB'
    if 'a55' in t_clean: return 'samsung_a55', capacity, ram or '8 GB'
    if 'a54' in t_clean: return 'samsung_a54', capacity, ram or '8 GB'
    if 'a53' in t_clean: return 'samsung_a53', capacity, ram or '8 GB'
    if 'a52s' in t_clean: return 'samsung_a52s', capacity, ram or '8 GB'
    if 'a52 5g' in t_clean: return 'samsung_a52_5g', capacity, ram or '8 GB'
    if 'a52' in t_clean: return 'samsung_a52', capacity, ram or '8 GB'
    if 'a51 5g' in t_clean: return 'samsung_a51_5g', capacity, ram or '6 GB'
    if 'a51' in t_clean: return 'samsung_a51', capacity, ram or '6 GB'
    if 'a50s' in t_clean: return 'samsung_a50s', capacity, ram or '4 GB'
    if 'a50' in t_clean: return 'samsung_a50', capacity, ram or '4 GB'
    if 'a41' in t_clean: return 'samsung_a41', capacity, ram or '4 GB'
    if 'a35' in t_clean: return 'samsung_a35', capacity, ram or '8 GB'
    if 'a34' in t_clean: return 'samsung_a34', capacity, ram or '8 GB'
    if 'a33' in t_clean: return 'samsung_a33', capacity, ram or '6 GB'
    if 'a32' in t_clean: return 'samsung_a32', capacity, ram or '6 GB'
    if 'a25' in t_clean: return 'samsung_a25', capacity, ram or '6 GB'
    if 'a23 5g' in t_clean: return 'samsung_a23_5g', capacity, ram or '6 GB'
    if 'a23' in t_clean: return 'samsung_a23', capacity, ram or '4 GB'
    if 'a15' in t_clean: return 'samsung_a15', capacity, ram or '8 GB'
    if 'galaxy 14' in t_clean or 'a14' in t_clean: return 'samsung_a14', capacity, ram or '4 GB'
    if 'a12' in t_clean: return 'samsung_a12', capacity, ram or '4 GB'
    if 'a06' in t_clean: return 'samsung_a06', capacity, ram or '4 GB'
    if 'a05s' in t_clean: return 'samsung_a05s', capacity, ram or '4 GB'
    if 'a05' in t_clean: return 'samsung_a05', capacity, ram or '4 GB'
    if 'a04s' in t_clean: return 'samsung_a04s', capacity, ram or '4 GB'
    if 'a04' in t_clean: return 'samsung_a04', capacity, ram or '3 GB'
    if 'a03s' in t_clean: return 'samsung_a03s', capacity, ram or '4 GB'
    if 'a03' in t_clean: return 'samsung_a03', capacity, ram or '3 GB'
    if 'a9 2018' in t_clean: return 'samsung_a9_2018', capacity, ram or '6 GB'
    if 'a8 plus 2018' in t_clean: return 'samsung_a8_plus_2018', capacity, ram or '6 GB'
    if 'a8 2018' in t_clean: return 'samsung_a8_2018', capacity, ram or '4 GB'
    if 'a7 2018' in t_clean: return 'samsung_a7_2018', capacity, ram or '4 GB'
    if 'a6 plus 2018' in t_clean: return 'samsung_a6_plus_2018', capacity, ram or '4 GB'
    if 'a6 2018' in t_clean: return 'samsung_a6_2018', capacity, ram or '3 GB'
    if 'galaxy 20s' in t_clean: return 'samsung_a20s', capacity, ram or '3 GB'
    if 'm55' in t_clean: return 'samsung_m55', capacity, ram or '8 GB'
    if 'm51' in t_clean: return 'samsung_m51', capacity, ram or '8 GB'
    if 'm34' in t_clean: return 'samsung_m34', capacity, ram or '8 GB'
    if 'm33' in t_clean: return 'samsung_m33', capacity, ram or '6 GB'
    if 'm31' in t_clean: return 'samsung_m31', capacity, ram or '6 GB'
    if 'm30s' in t_clean: return 'samsung_m30s', capacity, ram or '4 GB'
    if 'm30' in t_clean: return 'samsung_m30', capacity, ram or '4 GB'
    if 'm21s' in t_clean: return 'samsung_m21s', capacity, ram or '4 GB'
    if 'm21' in t_clean: return 'samsung_m21', capacity, ram or '4 GB'
    if 'm20' in t_clean: return 'samsung_m20', capacity, ram or '3 GB'
    if 'm15' in t_clean: return 'samsung_m15', capacity, ram or '4 GB'
    if 'm14' in t_clean: return 'samsung_m14', capacity, ram or '4 GB'
    if 'm11' in t_clean: return 'samsung_m11', capacity, ram or '3 GB'
    if 'j7 pro' in t_clean: return 'samsung_j7_pro', capacity, ram or '3 GB'
    if 'j7 prime' in t_clean: return 'samsung_j7_prime', capacity, ram or '3 GB'
    if 'j7 plus' in t_clean: return 'samsung_j7_plus', capacity, ram or '4 GB'

    # Xiaomi
    if '14 ultra' in t_clean: return 'xiaomi_14_ultra', capacity, ram or '16 GB'
    if '14pro' in t_clean or '14 pro' in t_clean: return 'xiaomi_14_pro', capacity, ram or '12 GB'
    if '14t pro' in t_clean: return 'xiaomi_14t_pro', capacity, ram or '12 GB'
    if '14t' in t_clean: return 'xiaomi_14t', capacity, ram or '12 GB'
    if '14' in t_clean and 'note' not in t_clean: return 'xiaomi_14', capacity, ram or '8 GB'
    if '13 lite' in t_clean: return 'xiaomi_13_lite', capacity, ram or '8 GB'
    if '13t' in t_clean: return 'xiaomi_13t', capacity, ram or '12 GB'
    if '13' in t_clean and 'note' not in t_clean: return 'xiaomi_13', capacity, ram or '8 GB'
    if '12 pro' in t_clean: return 'xiaomi_12_pro', capacity, ram or '12 GB'
    if '12 lite' in t_clean: return 'xiaomi_12_lite', capacity, ram or '8 GB'
    if '12t pro' in t_clean: return 'xiaomi_12t_pro', capacity, ram or '12 GB'
    if '12t' in t_clean: return 'xiaomi_12t', capacity, ram or '8 GB'
    if '12' in t_clean and 'note' not in t_clean and '12c' not in t_clean: return 'xiaomi_12', capacity, ram or '8 GB'
    if '11t pro' in t_clean: return 'xiaomi_11t_pro', capacity, ram or '8 GB'
    if '11t' in t_clean: return 'xiaomi_11t', capacity, ram or '8 GB'
    if '11 lite' in t_clean: return 'xiaomi_11_lite', capacity, ram or '8 GB'
    if 'poco x6 pro' in t_clean: return 'poco_x6_pro', capacity, ram or '8 GB'
    if 'poco x5 pro' in t_clean: return 'poco_x5_pro', capacity, ram or '8 GB'
    if 'poco x5' in t_clean: return 'poco_x5', capacity, ram or '6 GB'
    if 'poco x4 gt' in t_clean: return 'poco_x4_gt', capacity, ram or '8 GB'
    if 'poco x3 pro' in t_clean: return 'poco_x3_pro', capacity, ram or '8 GB'
    if 'poco x3 nfc' in t_clean: return 'poco_x3_nfc', capacity, ram or '6 GB'
    if 'poco f4' in t_clean: return 'poco_f4', capacity, ram or '8 GB'
    if 'redmi 12c' in t_clean: return 'redmi_12c', capacity, ram or '4 GB'
    if 'note 14' in t_clean: return 'redmi_note_14', capacity, ram or '6 GB'
    if 'note 13 pro' in t_clean: return 'redmi_note_13_pro', capacity, ram or '8 GB'
    if 'note 13' in t_clean: return 'redmi_note_13', capacity, ram or '6 GB'
    if 'note 12 pro 5g' in t_clean: return 'redmi_note_12_pro_5g', capacity, ram or '8 GB'
    if 'note 12 pro 4g' in t_clean or 'note 12 pro' in t_clean: return 'redmi_note_12_pro_4g', capacity, ram or '8 GB'
    if 'note 11 pro plus' in t_clean: return 'redmi_note_11_pro_plus', capacity, ram or '8 GB'
    if 'note 11 pro 5g' in t_clean: return 'redmi_note_11_pro_5g', capacity, ram or '8 GB'
    if 'note 11 pro' in t_clean: return 'redmi_note_11_pro', capacity, ram or '8 GB'
    if 'note 11s' in t_clean: return 'redmi_note_11s', capacity, ram or '6 GB'
    if 'note 10 pro' in t_clean: return 'redmi_note_10_pro', capacity, ram or '6 GB'
    if 'note 10s' in t_clean: return 'redmi_note_10s', capacity, ram or '6 GB'
    if 'note 10 5g' in t_clean: return 'redmi_note_10_5g', capacity, ram or '4 GB'
    if 'note 10' in t_clean: return 'redmi_note_10', capacity, ram or '4 GB'

    return None, capacity, ram

if __name__ == '__main__':
    import json
    with open('phonex-theme/data/used-phones.json') as f:
        used = json.load(f)
    missing = [x for x in used if not x.get('spec_groups')]
    
    unmatched = []
    matched = 0
    for x in missing:
        raw = x.get('raw_name') or x.get('name')
        key, cap, ram = detect_model_key(raw)
        if key:
            matched += 1
        else:
            unmatched.append(raw)
            
    print(f"Matched: {matched}/{len(missing)}")
    if unmatched:
        print("Unmatched:")
        for u in unmatched:
            print(" -", u)
