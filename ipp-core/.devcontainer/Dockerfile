FROM mcr.microsoft.com/devcontainers/php:8.3

# Set the locale
RUN sed -i '/cs_CZ.UTF-8/s/^# //g' /etc/locale.gen && \
    locale-gen
ENV LANG cs_CZ.UTF-8
ENV LC_ALL cs_CZ.UTF-8

# Install utilities and Python
RUN apt-get update && apt-get install -y \
    dos2unix \
    python3 \
    python3-pip \
    && rm -rf /var/lib/apt/lists/*

# Optional: If you need to install specific Python packages, you can do so with pip.
# For example, to install Flask:
# RUN python3 -m pip install Flask
