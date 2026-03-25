import codecs

path = 'c:/Users/bekbo/Desktop/работа проекта 2/views/plan.php'
with codecs.open(path, 'r', 'utf-8') as f:
    content = f.read()

# I will find the end of the <style> block and insert a powerful Mobile Fix CSS block.
# Wait, let's insert it immediately before the `</style>` that closes the top section.
# Or better, I can just replace my inline wizard styles, since they contain mobile fixes.

start_marker = "/* MOBILE FIXES WIZARD */"
end_marker = "</style>"
if start_marker in content:
    idx = content.find(start_marker)
    idx_end = content.find(end_marker, idx)
    
    if idx != -1 and idx_end != -1:
        pre = content[:idx]
        post = content[idx_end:]
        
        new_css = """
                /* MOBILE FIXES WIZARD */
                @media (max-width: 768px) {
                    /* Wizard responsive layout */
                    .wizard-content > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; gap: 12px !important; }
                    .wizard-content > div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
                    .wizard-content .form-group > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; gap: 12px !important; }
                    
                    /* Grid Overrides for horizontal overflow */
                    #plansList { grid-template-columns: 1fr !important; gap: 16px !important; }
                    .split-layout { grid-template-columns: 1fr !important; gap: 24px !important; display: flex !important; flex-direction: column !important; }
                    .left-column { position: static !important; }
                    
                    /* Form padding tight fit */
                    .plan-page { padding: 16px 12px !important; overflow-x: hidden !important; }
                    body { overflow-x: hidden !important; }
                    #planCard { padding: 20px 16px !important; border-radius: 16px !important; }

                    /* Fix wizard step labels on mobile */
                    .wizard-progress { margin-bottom: 24px !important; }
                    .ws-label { font-size: 9px !important; line-height: 1.1; margin-top: 4px; color: rgba(255,255,255,0.7) !important; text-align: center; }
                    
                    /* Fix map header blowing out the container width */
                    .map-card > div:first-child { flex-direction: column !important; align-items: flex-start !important; gap: 16px !important; padding: 16px !important; }
                    .map-card > div:first-child > div { width: 100% !important; justify-content: space-between !important; }
                    .map-card > div:first-child button { flex: 1 !important; text-align: center !important; font-size: 11px !important; padding: 10px !important; }
                    
                    /* Map container */
                    .map-card { min-height: 380px !important; border-radius: 16px !important; margin-bottom: 32px !important; }
                    #mapContainer, #map { min-height: 380px !important; }
                    
                    /* Strategy chips typography */
                    .strategy-chip .chip-content { padding: 12px !important; gap: 12px !important; flex-direction: row !important; }
                    .strategy-chip .chip-content > span:first-child { font-size: 24px !important; }
                    .strategy-chip .chip-content strong, .strategy-chip .chip-content > div > div:first-child { font-size: 14px !important; }
                    
                    h2 { font-size: 20px !important; }
                    h3 { font-size: 18px !important; }
                    .form-group { margin-bottom: 16px !important; }
                }
                """
        content = pre + new_css + post

with codecs.open(path, 'w', 'utf-8') as f:
    f.write(content)
print("SUCCESS!")
