#!/usr/bin/env bash
set -euo pipefail

# Script de backup diário do banco SQLite e dos arquivos públicos (storage/app/public)
# Exemplo de uso no crontab (todo dia às 03:00):
# 0 3 * * * /opt/kobs-dev/docker/scripts/backup.sh >> /var/log/kobs-backup.log 2>&1

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
BACKUP_DIR="${BACKUP_DIR:-${ROOT_DIR}/backups}"
RETENTION_DAYS="${RETENTION_DAYS:-14}"
TIMESTAMP="$(date +%Y%m%d_%H%M%S)"

DB_FILE="${ROOT_DIR}/backend/database/database.sqlite"
STORAGE_DIR="${ROOT_DIR}/backend/storage/app/public"

mkdir -p "${BACKUP_DIR}"

if [ -f "${DB_FILE}" ]; then
  if command -v sqlite3 >/dev/null 2>&1; then
    sqlite3 "${DB_FILE}" ".backup '${BACKUP_DIR}/database_${TIMESTAMP}.sqlite'"
  else
    cp "${DB_FILE}" "${BACKUP_DIR}/database_${TIMESTAMP}.sqlite"
  fi
  gzip -f "${BACKUP_DIR}/database_${TIMESTAMP}.sqlite"
fi

if [ -d "${STORAGE_DIR}" ]; then
  tar -czf "${BACKUP_DIR}/storage_public_${TIMESTAMP}.tar.gz" -C "${STORAGE_DIR}" .
fi

find "${BACKUP_DIR}" -type f \( -name "database_*.sqlite.gz" -o -name "storage_public_*.tar.gz" \) -mtime +"${RETENTION_DAYS}" -delete

echo "[$(date -Iseconds)] Backup concluído em ${BACKUP_DIR}"
