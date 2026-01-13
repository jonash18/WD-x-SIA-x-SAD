const OLLAMA_API_URL = 'http://localhost:11434/api/generate';
const OLLAMA_MODEL = 'llama2:latest';

export async function summarizeDocument(docText) {
  const panel = document.getElementById('aiSummary');
  const output = document.getElementById('aiSummaryText');
  panel.style.display = 'block';
  output.textContent = 'Typing...';

  const prompt = `Provide a customer service reply from this. Include solution plan and suggests\n\n${docText}`;

  try {
    const resp = await fetch(OLLAMA_API_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        model: OLLAMA_MODEL,
        prompt: prompt,
        stream: false,
        temperature: 0.3,
        num_predict: 200
      })
    });

    if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
    const data = await resp.json();
    output.textContent = (data.response || '').trim() || 'No AI summary available.';
  } catch (err) {
    output.textContent = `Error: Could not connect to Ollama. Is it running? (${err.message})`;
  }
}