<!-- Профиль ветеринара -->
<div style="padding: 20px;" class="animate-fade-in">
    <div class="dash-aura">
        <div class="d-blob d-blob-1"></div>
        <div class="d-blob d-blob-2"></div>
    </div>

    <div style="margin-bottom: 32px; position: relative; z-index: 10;">
        <a href="/dashboard" class="btn btn-outline"
            style="text-decoration: none; padding: 12px 24px; font-size: 15px; border-radius: 14px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); color: #fff; display: inline-flex; align-items: center; gap: 8px; backdrop-filter: blur(10px);">
            <svg class="icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"></path>
            </svg>
            Вернуться в панель управления
        </a>
    </div>

    <style>
        .dash-aura {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .d-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.1;
        }

        .d-blob-1 {
            width: 60vw;
            height: 60vw;
            background: #b4a18a;
            top: -10%;
            left: -10%;
        }

        .d-blob-2 {
            width: 50vw;
            height: 50vw;
            background: #849483;
            bottom: -10%;
            right: -5%;
        }

        .animate-fade-in {
            position: relative;
            z-index: 1;
        }

        body {
            background: #070605;
            color: #fff;
        }

        .card {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.07) !important;
            backdrop-filter: blur(20px);
            color: #fff;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .form-input {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }
    </style>

    <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 24px;">Мой профиль ветеринара</h1>

    <div class="card" style="padding: 24px;">
        <form id="vetProfileForm">
            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Полное имя</label>
                <input type="text" class="form-input" id="fullName" placeholder="Иванов Иван Иванович">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Специализация (через запятую)</label>
                <input type="text" class="form-input" id="specialization" placeholder="КРС, Мелкий рогатый скот, Птица">
                <small style="color: var(--text-secondary); font-size: 12px;">Укажите виды животных, с которыми
                    работаете</small>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group">
                    <label class="form-label">Опыт работы (лет)</label>
                    <input type="number" class="form-input" id="experienceYears" min="0" placeholder="5">
                </div>
                <div class="form-group">
                    <label class="form-label">Цена консультации (сом)</label>
                    <input type="number" class="form-input" id="consultationPrice" min="0" step="0.01"
                        placeholder="500">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Образование</label>
                <textarea class="form-input" id="education" rows="3"
                    placeholder="КГАУ, факультет ветеринарии, 2015"></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Сертификаты (через запятую)</label>
                <input type="text" class="form-input" id="certifications"
                    placeholder="Сертификат по хирургии, Сертификат по терапии">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">О себе</label>
                <textarea class="form-input" id="bio" rows="5"
                    placeholder="Расскажите о себе, опыте работы, подходах к лечению..."></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" id="isAvailable" checked style="width: 20px; height: 20px;">
                    <span>Доступен для консультаций</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary"
                style="width: 100%; padding: 14px; font-size: 16px; font-weight: 600;">
                Сохранить профиль
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        loadProfile();

        document.getElementById('vetProfileForm').addEventListener('submit', function (e) {
            e.preventDefault();
            saveProfile();
        });
    });

    function loadProfile() {
        fetch('/api/vet-profile')
            .then(r => r.json())
            .then(data => {
                if (data.success && data.profile) {
                    const p = data.profile;
                    document.getElementById('fullName').value = p.full_name || '';
                    document.getElementById('specialization').value = Array.isArray(p.specialization) ? p.specialization.join(', ') : (p.specialization || '');
                    document.getElementById('experienceYears').value = p.experience_years || '';
                    document.getElementById('consultationPrice').value = p.consultation_price || '';
                    document.getElementById('education').value = p.education || '';
                    document.getElementById('certifications').value = Array.isArray(p.certifications) ? p.certifications.join(', ') : (p.certifications || '');
                    document.getElementById('bio').value = p.bio || '';
                    document.getElementById('isAvailable').checked = p.is_available !== false;
                }
            })
            .catch(err => console.error('Ошибка загрузки профиля:', err));
    }

    function saveProfile() {
        const formData = {
            full_name: document.getElementById('fullName').value,
            specialization: document.getElementById('specialization').value.split(',').map(s => s.trim()).filter(s => s),
            experience_years: parseInt(document.getElementById('experienceYears').value) || null,
            consultation_price: parseFloat(document.getElementById('consultationPrice').value) || null,
            education: document.getElementById('education').value,
            certifications: document.getElementById('certifications').value.split(',').map(s => s.trim()).filter(s => s),
            bio: document.getElementById('bio').value,
            is_available: document.getElementById('isAvailable').checked
        };

        fetch('/api/vet-profile', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('✅ Профиль сохранен!');
                } else {
                    alert('❌ Ошибка: ' + (data.error || 'Не удалось сохранить'));
                }
            })
            .catch(err => {
                console.error('Ошибка сохранения:', err);
                alert('❌ Ошибка при сохранении профиля');
            });
    }
</script>