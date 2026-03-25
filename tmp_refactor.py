import codecs

path = 'c:/Users/bekbo/Desktop/работа проекта 2/views/plan.php'
with codecs.open(path, 'r', 'utf-8') as f:
    content = f.read()

marker1_old = """    <div class="card" id="planCard">
        <form id="planForm">
            <!-- Основные данные -->
            <div class="form-step" style="display: block;">
                <h2 style="font-size: 28px; font-weight: 700; margin-bottom: 32px;">Основные параметры</h2>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">"""

marker1_new = """    <div class="split-layout" style="display: grid; grid-template-columns: 460px 1fr; gap: 40px; align-items: start; position: relative; z-index: 10;">
    
    <div style="display: flex; flex-direction: column; gap: 24px; position: sticky; top: 20px;">
    <div class="card" id="planCard" style="padding: 32px; border-radius: 24px; background: rgba(20,22,18,0.8) !important; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
        <form id="planForm">
            <!-- Основные данные -->
            <div class="form-step" style="display: block;">
                <h2 style="font-size: 24px; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; color: #fff;">
                    <svg width="24" height="24" fill="none" stroke="var(--accent)" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                    Конфигуратор плана
                </h2>

                <div style="display: flex; flex-direction: column; gap: 24px;">"""

content = content.replace(marker1_old, marker1_new)


marker2_old = """                    </div>

                    <div>
                        <div class="form-group" style="margin-bottom: 24px;">"""

marker2_new = """                    
                        <div class="form-group" style="margin-bottom: 24px;">"""
content = content.replace(marker2_old, marker2_new)


marker3_old = """                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Модальное окно с картой -->
<div id="mapModal"
    style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.85); z-index: 2000; padding: 40px; backdrop-filter: blur(10px);">
    <div class="card"
        style="max-width: 1000px; margin: 0 auto; height: 100%; display: flex; flex-direction: column; overflow: hidden; padding: 0;">
        <div
            style="padding: 24px; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 24px; font-weight: 700; margin: 0;">Границы участка</h2>
            <button type="button" id="closeMapBtn"
                style="background: rgba(255,255,255,0.05); border: none; color: #fff; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        <div id="mapContainer" style="flex: 1; min-height: 400px; position: relative;">
            <div id="map" style="width: 100%; height: 100%;"></div>
        </div>
        <div
            style="padding: 24px; border-top: 1px solid var(--glass-border); display: flex; gap: 12px; justify-content: flex-end;">
            <button type="button" class="btn btn-outline" id="clearMapBtn"
                style="background: transparent; border: 1px solid var(--glass-border); color: #fff; padding: 12px 24px; border-radius: 12px; cursor: pointer;">Очистить</button>
            <button type="button" class="btn btn-primary" id="saveMapBtn">Сохранить границы</button>
        </div>
    </div>
</div>"""

marker3_new = """                    </button>
                </div>
            </div>
        </form>
    </div>
    </div> <!-- End left column container -->

    <!-- ВТОРАЯ КОЛОНКА (КАРТА И ОТЧЕТЫ) -->
    <div class="right-column" style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Карта всегда видима -->
        <div class="card map-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; min-height: 500px; border-radius: 24px; background: rgba(0,0,0,0.3) !important; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 10px 40px rgba(0,0,0,0.3); transition: box-shadow 0.3s;">
            <div style="padding: 16px 24px; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.02);">
                <h2 style="font-size: 16px; font-weight: 700; margin: 0; display:flex; align-items:center; gap:8px; color: #fff; text-transform: uppercase; letter-spacing: 0.05em;">
                    <svg width="18" height="18" fill="none" stroke="var(--accent)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Рабочая область карты
                </h2>
                <div style="display:flex; gap:12px;">
                    <button type="button" class="btn btn-outline" id="clearMapBtn" style="background: transparent; border: 1px solid var(--glass-border); color: #fff; padding: 8px 16px; border-radius: 10px; font-size: 12px; cursor: pointer;">Очистить слой</button>
                    <button type="button" class="btn btn-primary" id="saveMapBtn" style="padding: 8px 16px !important; font-size: 12px !important; border-radius: 10px !important;">Утвердить границы</button>
                </div>
            </div>
            <div id="mapContainer" style="flex: 1; position: relative;">
                <div id="map" style="width: 100%; height: 100%; min-height: 500px; position:absolute; inset:0;"></div>
            </div>
        </div>"""

content = content.replace(marker3_old, marker3_new)

marker4_old = """<div style="margin-top: 60px;">
    <h2 style="font-size: 28px; margin-bottom: 32px; font-weight: 700;">Ваши планы посева</h2>"""
marker4_new = """<div style="margin-top: 16px;">
    <h2 style="font-size: 24px; margin-bottom: 24px; font-weight: 700; color: #fff;">Недавние проекты</h2>"""
content = content.replace(marker4_old, marker4_new)


marker5_old = """    // Справочник культур для автодополнения
    const cropsList = ["""
marker5_new = """    // Справочник культур для автодополнения
    function openMapModal() {
        document.getElementById('map').scrollIntoView({behavior: 'smooth', block: 'center'});
        const mapCard = document.querySelector('.map-card');
        if(mapCard) {
            mapCard.style.boxShadow = '0 0 0 4px var(--accent)';
            setTimeout(() => mapCard.style.boxShadow = '0 10px 40px rgba(0,0,0,0.3)', 1000);
        }
    }
    function closeMapModal() {}
    
    // Справочник культур для автодополнения
    const cropsList = ["""
content = content.replace(marker5_old, marker5_new)


marker6_old = """        loadFarms();
        loadFields();
        loadPlans();
        initCropAutocomplete();"""
marker6_new = """        loadFarms();
        loadFields();
        loadPlans();
        initCropAutocomplete();
        setTimeout(() => initMap(), 500);"""
content = content.replace(marker6_old, marker6_new)


marker7_old = """    function openMapModal() {
        document.getElementById('mapModal').style.display = 'flex';

        if (!map) {
            setTimeout(() => initMap(), 100);
        } else {
            setTimeout(() => map.invalidateSize(), 100);
        }
    }

    function closeMapModal() {
        document.getElementById('mapModal').style.display = 'none';
    }"""
content = content.replace(marker7_old, "")

# Add closing dive for split-layout! Right now we didn't close it properly.
# We replaced marker3 with right-column start. Where does right-column end? It ends at the very end of the page block
# We had </div></div> at the end originally:
# 1056:     </div>
# 1057: </div>
# 1058: </div>
marker8_old = """    </div>
</div>
</div>

<!-- Leaflet для карты -->"""
marker8_new = """    </div>
</div> <!-- End right column -->
</div> <!-- End split-layout -->
</div>

<!-- Leaflet для карты -->"""
content = content.replace(marker8_old, marker8_new)

with codecs.open(path, 'w', 'utf-8') as f:
    f.write(content)
print("SUCCESS!")
