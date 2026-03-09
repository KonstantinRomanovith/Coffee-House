<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>

<div class="about-page">
    <div class="about-hero">
        <h1>О нашей компании</h1>
        <p>Мы создаем культуру кофе с 2010 года</p>
    </div>
    
    <div class="about-story">
        <div class="about-story-content">
            <h2>Наша история</h2>
            <p>Все началось с маленькой кофейни в центре Москвы. Мы варили кофе для своих друзей и соседей, и постепенно наша любовь к этому напитку переросла в нечто большее. Сегодня мы - команда профессионалов, которые знают о кофе всё.</p>
            <p>Мы путешествуем по миру в поисках лучших кофейных зерен, работаем напрямую с фермерами и контролируем каждый этап производства - от сбора урожая до обжарки.</p>
        </div>
        <div class="about-story-image">
            <img src="assets/images/about-story.jpg" alt="Наша история">
        </div>
    </div>
    
    <div class="about-values">
        <h2>Наши ценности</h2>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🌱</div>
                <h3>Качество</h3>
                <p>Мы отбираем только лучшие сорта кофе и тщательно контролируем качество на всех этапах</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3>Честность</h3>
                <p>Прямые контракты с фермерами и справедливая цена для всех участников цепочки</p>
            </div>
            <div class="value-card">
                <div class="value-icon">💚</div>
                <h3>Экологичность</h3>
                <p>Мы используем только биоразлагаемую упаковку и поддерживаем экологические проекты</p>
            </div>
            <div class="value-card">
                <div class="value-icon">❤️</div>
                <h3>Любовь к делу</h3>
                <p>Каждую партию мы обжариваем с любовью и заботой о наших клиентах</p>
            </div>
        </div>
    </div>
    
    <div class="about-team">
        <h2>Наша команда</h2>
        <div class="team-grid">
            <div class="team-member">
                <img src="assets/images/team1.jpg" alt="Алексей">
                <h3>Алексей Петров</h3>
                <p>Главный обжарщик</p>
            </div>
            <div class="team-member">
                <img src="assets/images/team2.jpg" alt="Мария">
                <h3>Мария Иванова</h3>
                <p>Кофейный сомелье</p>
            </div>
            <div class="team-member">
                <img src="assets/images/team3.jpg" alt="Дмитрий">
                <h3>Дмитрий Сидоров</h3>
                <p>Логистика</p>
            </div>
        </div>
    </div>
    
    <?php if (isLoggedIn()): ?>
    <div class="feedback-form">
        <h2>Обратная связь</h2>
        <form id="feedbackForm">
            <div class="form-group">
                <label for="name">Ваше имя</label>
                <input type="text" id="name" name="name" value="<?php echo $_SESSION['username']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Сообщение</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn">Отправить</button>
        </form>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>