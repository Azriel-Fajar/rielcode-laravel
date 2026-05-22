// Chatbot boot — deferred to idle so first paint isn't blocked by ~33KB parse + DOM injection.
(function rielChatbotBoot() {
  const __initChatbot = function () {
  const chatbotHTML = `
<div id="chatbot-icon" class="chatbot-icon" title="Chat with RielBot">
  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
  </svg>
  <span id="chatbot-badge" class="chatbot-badge">1</span>
</div>

<!-- Greeting bubble above chatbot icon -->
<div id="chatbot-greeting" class="chatbot-greeting">
  👋 Hi! Anything I can help with?
  <button id="chatbot-greeting-close" class="chatbot-greeting-close">×</button>
</div>

<!-- Chatbot Window -->
<div id="chatbot-container" class="chatbot-container hidden">

  <!-- Header -->
  <div class="chat-header">
    <div class="chat-header-info">
      <div class="chat-header-title">
        <span class="chat-header-name">RielBot</span>
        <span class="chat-header-status">online</span>
      </div>
    </div>
    <button id="close-chat" class="close-btn" title="Close">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
        <line x1="18" y1="6" x2="6" y2="18"/>
        <line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </button>
  </div>

  <!-- Messages -->
  <div id="chat-messages" class="chat-messages"></div>

  <!-- Quick Reply Dropup -->
  <div id="quick-replies" class="quick-replies-dropup">
    <div id="quick-menu" class="quick-menu">
      <button class="quick-chip" data-msg="What packages do you offer?">📦 View Packages</button>
      <button class="quick-chip" data-msg="How much does a Rielcode package cost?">💰 Check Pricing</button>
      <button class="quick-chip" data-msg="Tell me about the Custom Plan presets (Copy Website and E-Commerce)">⚡ Custom Plan</button>
      <button class="quick-chip" data-msg="How do I order a website?">🚀 How to Order</button>
    </div>
    <button id="quick-toggle" class="quick-toggle" title="Quick questions">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
      Quick Ask
    </button>
  </div>

  <!-- Input -->
  <div class="chat-input">
    <input type="text" id="user-input" placeholder="Ask me anything…" autocomplete="off" />
    <button id="send-btn" title="Send">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="22" y1="2" x2="11" y2="13"/>
        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
      </svg>
    </button>
  </div>

</div>
`;

  document.body.insertAdjacentHTML("beforeend", chatbotHTML);

  const promo = document.querySelector(".rc-promo--bottom-bar");

  // Start widget at base corner position — lifted by updateChatbotOffset once promo mounts
  const _initBase = window.innerWidth <= 500 ? 16 : 25;
  document.getElementById("chatbot-icon").style.bottom = _initBase + "px";
  document.getElementById("chatbot-greeting").style.bottom = (_initBase + 68) + "px";
  document.getElementById("chatbot-container").style.bottom = (_initBase + 70) + "px";
  const chatIcon = document.getElementById("chatbot-icon");
  const chatContainer = document.getElementById("chatbot-container");
  const closeBtn = document.getElementById("close-chat");
  const sendBtn = document.getElementById("send-btn");
  const input = document.getElementById("user-input");
  const messages = document.getElementById("chat-messages");
  const badge = document.getElementById("chatbot-badge");
  const greeting = document.getElementById("chatbot-greeting");
  const greetingClose = document.getElementById("chatbot-greeting-close");
  const quickReplies = document.getElementById("quick-replies");

  // ─── Chat API URLs (Laravel routes) ─────────────────────────────────────────
  const PROXY_URL        = window.location.origin + "/api/chat";
  const PROXY_URL_STREAM = window.location.origin + "/api/chat/stream";
  // ─────────────────────────────────────────────────────────────────────────────

  // ─── Greeting bubble auto-show (after 3 s) ───────────────────────────────
  let greetingSent = false;
  setTimeout(() => {
    if (chatContainer.classList.contains("hidden")) {
      greeting.classList.add("visible");
    }
  }, 3000);

  greetingClose.addEventListener("click", (e) => {
    e.stopPropagation();
    greeting.classList.remove("visible");
    badge.style.display = "none";
  });

  // ─── Scroll state (declared here so click/close handlers can access it) ───
  let lastScrollTop = 0;
  let promoHiddenByScroll = false;

  // ─── UI event listeners ───────────────────────────────────────────────────
  chatIcon.addEventListener("click", () => {
    chatContainer.classList.toggle("hidden");
    greeting.classList.remove("visible");
    badge.style.display = "none";

    const isOpen = !chatContainer.classList.contains("hidden");

    if (isOpen) {
      // Opening: hide promo to avoid overlap
      if (promo && !promo.classList.contains("is-dismissed")) {
        promo.classList.add("is-hidden-scroll");
        promoHiddenByScroll = true;
        updateChatbotOffset(false);
      }
    } else {
      // Closing via icon: restore promo visibility
      if (promo && promo.classList.contains("is-mounted") && promo.classList.contains("is-hidden-scroll")) {
        promo.classList.remove("is-hidden-scroll");
        promoHiddenByScroll = false;
      }
    }

    if (isOpen) {
      // Send bot greeting on first open
      if (!greetingSent) {
        greetingSent = true;
        setTimeout(() => {
          const typingDiv = addMessage("bot", "");
          typingDiv.classList.add("typing");
          typingDiv.innerHTML = "<span></span><span></span><span></span>";
          setTimeout(() => {
            typingDiv.classList.remove("typing");
            typingDiv.innerHTML =
              "👋 Hi! I'm <strong>RielBot</strong>, Rielcode's virtual assistant.<br><br>Want to ask about packages, pricing, or how to order? Just ask — or click one of the buttons below! 😊";
            messages.scrollTop = messages.scrollHeight;
          }, 1200);
        }, 300);
      }
      setTimeout(() => input.focus(), 100);
    }

    if (typeof gtag === "function") {
      gtag("event", "chat_open", {
        event_category: "Chatbot",
        event_label: "User opened chatbot",
      });
    }
  });

  function closeChat() {
    chatContainer.classList.add("hidden");
    // Restore promo visibility if hidden only because chatbot was open
    if (promo && promo.classList.contains("is-mounted") && promo.classList.contains("is-hidden-scroll")) {
      promo.classList.remove("is-hidden-scroll");
      promoHiddenByScroll = false;
    }
  }

  closeBtn.addEventListener("click", () => {
    closeChat();
    if (typeof gtag === "function") {
      gtag("event", "chat_close", {
        event_category: "Chatbot",
        event_label: "User closed chatbot",
      });
    }
  });

  // ─── Click-outside-to-close ────────────────────────────────────────────────
  document.addEventListener("click", (e) => {
    if (chatContainer.classList.contains("hidden")) return;
    // Ignore clicks inside the chatbot container or on the icon
    if (chatContainer.contains(e.target) || chatIcon.contains(e.target)) return;
    closeChat();
  });

  // ─── Quick reply dropup ────────────────────────────────────────────────────
  const quickToggle = document.getElementById("quick-toggle");
  const quickMenu = document.getElementById("quick-menu");

  quickToggle.addEventListener("click", (e) => {
    e.stopPropagation();
    quickMenu.classList.toggle("open");
    quickToggle.classList.toggle("open");
  });

  quickReplies.addEventListener("click", (e) => {
    const chip = e.target.closest(".quick-chip");
    if (!chip) return;
    input.value = chip.dataset.msg;
    sendMessage();
    // Close the dropup but keep it accessible
    quickMenu.classList.remove("open");
    quickToggle.classList.remove("open");
  });

  sendBtn.addEventListener("click", sendMessage);
  input.addEventListener("keypress", (e) => {
    if (e.key === "Enter") sendMessage();
  });

  // ─── Message rendering ────────────────────────────────────────────────────
  function addMessage(sender, text) {
    const div = document.createElement("div");
    div.className = `message ${sender}`;
    div.textContent = text;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;

    // Resize container to fit content (capped at max dimensions)
    const maxWidth = window.innerWidth > 768 ? 500 : window.innerWidth * 0.9;
    const maxHeight = window.innerWidth > 768 ? 600 : 400;
    chatContainer.style.height =
      Math.min(messages.scrollHeight + 120, maxHeight) + "px";
    chatContainer.style.width =
      Math.min(messages.scrollWidth + 40, maxWidth) + "px";

    return div;
  }

  // ─── Markdown parser ──────────────────────────────────────────────────────
  function parseMarkdown(text) {
    return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/\*\*(.+?)\*\*/g, "<strong>$1</strong>")
      .replace(/\*(.+?)\*/g, "<strong>$1</strong>")
      .replace(/\n/g, "<br>");
  }

  // ─── Send & fetch ─────────────────────────────────────────────────────────
  async function sendMessage() {
    const text = input.value.trim();
    if (!text) return;
    input.value = "";

    if (typeof gtag === "function") {
      gtag("event", "chat_message", {
        event_category: "Chatbot",
        event_label: text,
      });
    }

    // Local identity shortcut (no API call needed)
    if (text.toLowerCase().includes("rielbot")) {
      addMessage(
        "bot",
        "Hi! I'm RielBot, Rielcode's virtual assistant. How can I help?",
      );
      return;
    }

    addMessage("user", text);
    const botMsgDiv = addMessage("bot", "");
    botMsgDiv.classList.add("typing");
    botMsgDiv.innerHTML = "<span></span><span></span><span></span>";

    // Highlight discounts in pricing-related replies
    function highlightPromo(replyText) {
      const priceKeywords = ["price", "pricing", "cost", "package", "plan", "how much"];
      if (priceKeywords.some((kw) => text.toLowerCase().includes(kw))) {
        return replyText.replace(/(Grand Opening.*?OFF)/gi, "🔥 $1 🔥");
      }
      return replyText;
    }

    const streamingDisabled = sessionStorage.getItem("rc_stream_ok") === "0";

    try {
      if (!streamingDisabled) {
        await sendStreaming(text, botMsgDiv, highlightPromo);
      } else {
        await sendBlocking(text, botMsgDiv, highlightPromo);
      }
    } catch (err) {
      if (err && err.code === "NO_CHUNKS") {
        // Streaming likely buffered by Apache/FastCGI. Fall back to blocking JSON.
        sessionStorage.setItem("rc_stream_ok", "0");
        console.warn("[RielBot] Streaming watchdog tripped — falling back to blocking JSON.");
        try {
          await sendBlocking(text, botMsgDiv, highlightPromo);
        } catch (err2) {
          renderClientError(botMsgDiv, err2);
        }
      } else {
        renderClientError(botMsgDiv, err);
      }
    }
  }

  function renderClientError(div, err) {
    div.classList.remove("typing");
    if (err && err.name === "AbortError") {
      div.textContent = "⚠️ Request timed out. Please try again.";
    } else {
      const msg = (err && err.message) ? err.message : "Unknown error.";
      div.textContent = "⚠️ " + msg;
      console.warn("[RielBot] Error:", msg);
    }
  }

  // ─── Streaming send (SSE) ────────────────────────────────────────────────
  async function sendStreaming(text, div, highlightPromo) {
    const controller = new AbortController();
    const FIRST_CHUNK_MS = 5000;
    const HARD_TIMEOUT_MS = 60000;

    let gotChunk = false;
    const firstChunkTimer = setTimeout(() => {
      if (!gotChunk) controller.abort("no-chunks");
    }, FIRST_CHUNK_MS);
    const hardTimer = setTimeout(() => controller.abort("hard-timeout"), HARD_TIMEOUT_MS);

    let res;
    try {
      res = await fetch(PROXY_URL_STREAM, {
        method: "POST",
        headers: { "Content-Type": "application/json", "Accept": "text/event-stream" },
        body: JSON.stringify({ message: text, source: "chatbot" }),
        signal: controller.signal,
      });
    } catch (e) {
      clearTimeout(firstChunkTimer);
      clearTimeout(hardTimer);
      if (!gotChunk) throw { code: "NO_CHUNKS" };
      throw e;
    }

    // Server didn't honor SSE — fall back.
    const ct = (res.headers.get("content-type") || "").toLowerCase();
    console.log("[RielBot] stream response status=" + res.status + " ct=" + ct + " body=" + (res.body ? "ok" : "NULL"));
    if (!ct.includes("text/event-stream") && res.status !== 429) {
      clearTimeout(firstChunkTimer);
      clearTimeout(hardTimer);
      console.warn("[RielBot] CT mismatch → fallback");
      throw { code: "NO_CHUNKS" };
    }

    // 429 in SSE shape still gets emitted as event: error frames — handled below.
    // Guard: Opera and some browsers return null body for streamed responses.
    if (!res.body) {
      clearTimeout(firstChunkTimer);
      clearTimeout(hardTimer);
      console.warn("[RielBot] res.body null → fallback");
      throw { code: "NO_CHUNKS" };
    }
    const reader = res.body.getReader();
    const decoder = new TextDecoder();
    let buffer = "";
    let assembled = "";
    let parseFails = 0;

    while (true) {
      const { value, done } = await reader.read();
      if (done) break;
      gotChunk = true;
      clearTimeout(firstChunkTimer);
      buffer += decoder.decode(value, { stream: true });

      let idx;
      while ((idx = buffer.indexOf("\n\n")) !== -1) {
        const frame = buffer.slice(0, idx);
        buffer = buffer.slice(idx + 2);
        if (!frame.trim()) continue;

        let evt = "message", data = "";
        for (const line of frame.split("\n")) {
          if (line.startsWith("event:")) evt = line.slice(6).trim();
          else if (line.startsWith("data:")) data += line.slice(5).trim();
        }
        let parsed = null;
        try { parsed = data ? JSON.parse(data) : null; }
        catch (e) {
          parseFails++;
          if (parseFails > 3) { clearTimeout(hardTimer); throw new Error("SSE parse error"); }
          continue;
        }

        if (evt === "delta" && parsed && typeof parsed.v === "string") {
          if (div.classList.contains("typing")) {
            div.classList.remove("typing");
            div.textContent = "";
          }
          assembled += parsed.v;
          div.textContent = assembled;
          messages.scrollTop = messages.scrollHeight;
        } else if (evt === "usage") {
          // optional: stash on element if needed for debugging
        } else if (evt === "done") {
          // finalize
        } else if (evt === "error" && parsed) {
          clearTimeout(hardTimer);
          const replyText = parsed.reply || "⚠️ Unknown error.";
          div.innerHTML = parseMarkdown(replyText);
          return;
        }
      }
    }

    clearTimeout(hardTimer);
    if (!assembled) throw { code: "NO_CHUNKS" };
    div.innerHTML = parseMarkdown(highlightPromo(assembled));
  }

  // ─── Blocking send (JSON) — original path, used as fallback ─────────────
  async function sendBlocking(text, div, highlightPromo) {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 15000);

    let res;
    try {
      res = await fetch(PROXY_URL, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: text, source: "chatbot" }),
        signal: controller.signal,
      });
    } finally {
      clearTimeout(timeoutId);
    }

    // 4xx/5xx still carry a JSON body with .reply/.code — render it instead of throwing.
    let data;
    try { data = await res.json(); }
    catch (e) {
      throw new Error(`Server error (HTTP ${res.status}). URL tried: ${PROXY_URL}`);
    }

    div.classList.remove("typing");
    const replyText = highlightPromo(data.reply || "⚠️ No response.");
    div.innerHTML = parseMarkdown(replyText);
  }

  function updateChatbotOffset(promoUp) {
    const base = window.innerWidth <= 500 ? 16 : 25;
    const offset = promoUp ? (promo ? promo.offsetHeight : 0) + 12 : base;
    chatIcon.style.bottom = offset + "px";
    greeting.style.bottom = (offset + 68) + "px";
    // Container bottom = icon bottom + icon height (56px) + gap (14px)
    chatContainer.style.bottom = (offset + 70) + "px";
  }

  // ─── Promo mount / dismiss observer ──────────────────────────────────────
  if (promo) {
    new MutationObserver(() => {
      if (chatContainer.classList.contains("hidden")) {
        // Only reposition widget when chat is closed
        if (promo.classList.contains("is-dismissed")) {
          promoHiddenByScroll = false;
          updateChatbotOffset(false);
        } else if (promo.classList.contains("is-mounted")) {
          const hiddenByScroll = promo.classList.contains("is-hidden-scroll");
          updateChatbotOffset(!hiddenByScroll);
        }
      }
    }).observe(promo, { attributes: true, attributeFilter: ["class"] });
  }

  // ─── Scroll-based promo hide/show ────────────────────────────────────────
  window.addEventListener("scroll", () => {
    const scrollTop = window.scrollY;
    const scrollingDown = scrollTop > lastScrollTop;
    const chatOpen = !chatContainer.classList.contains("hidden");

    if (!chatOpen && promo && promo.classList.contains("is-mounted")) {
      if (scrollingDown && !promoHiddenByScroll) {
        promo.classList.add("is-hidden-scroll");
        promoHiddenByScroll = true;
      } else if (!scrollingDown && promoHiddenByScroll) {
        promo.classList.remove("is-hidden-scroll");
        promoHiddenByScroll = false;
      }
    }
    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
  });
  };
  const __schedule = window.requestIdleCallback || function (cb) { return setTimeout(cb, 1500); };
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      __schedule(__initChatbot, { timeout: 3000 });
    });
  } else {
    __schedule(__initChatbot, { timeout: 3000 });
  }
})();

