<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error" onclick="this.classList.add('hidden');"><?= $message ?></div>
<style>
    .message {
  padding: 10px 24px;
  margin: 10px auto;
  max-width: 600px;
  border-radius: 8px;
  font-size: 1.2rem;
  font-weight: bold;
  color: #fff;
  cursor: pointer;
  text-align: center;
  animation: slideFade 0.6s ease-in-out;
  transition: transform 0.3s ease, opacity 0.3s ease;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}



/* Error styling */
.message.error {
  background: linear-gradient(135deg, #ff1744, #ff5252);
  color: #ffffff;
}

/* Click-to-hide effect */
.message.hidden {
  opacity: 0;
  transform: translateY(-20px) scale(0.95);
  pointer-events: none;
}

/* Entry animation */
@keyframes slideFade {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Optional hover effect */
.message:hover {
  transform: scale(1.02);
  box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
}

</style>