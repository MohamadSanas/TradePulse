import fs from 'node:fs';
import path from 'node:path';

const manifestPath = path.resolve('public/build/manifest.json');

if (!fs.existsSync(manifestPath)) {
    process.exit(0);
}

const manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf8'));
const normalizedManifest = {};

const normalizeResourcePath = (value) => {
    if (typeof value !== 'string') {
        return value;
    }

    const normalized = value.replace(/\\/g, '/');
    const resourceIndex = normalized.lastIndexOf('/resources/');

    if (resourceIndex !== -1) {
        return normalized.slice(resourceIndex + 1);
    }

    if (normalized.startsWith('resources/')) {
        return normalized;
    }

    return value;
};

for (const [key, entry] of Object.entries(manifest)) {
    const normalizedKey = normalizeResourcePath(key);
    const normalizedEntry = { ...entry };

    if ('src' in normalizedEntry) {
        normalizedEntry.src = normalizeResourcePath(normalizedEntry.src);
    }

    if (Array.isArray(normalizedEntry.imports)) {
        normalizedEntry.imports = normalizedEntry.imports.map(normalizeResourcePath);
    }

    if (Array.isArray(normalizedEntry.dynamicImports)) {
        normalizedEntry.dynamicImports = normalizedEntry.dynamicImports.map(normalizeResourcePath);
    }

    normalizedManifest[normalizedKey] = normalizedEntry;
}

fs.writeFileSync(manifestPath, `${JSON.stringify(normalizedManifest, null, 2)}\n`);
