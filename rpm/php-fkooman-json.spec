Name:       php-fkooman-json
Version:    0.4.0
Release:    1%{?dist}
Summary:    JSON convenience library written in PHP

Group:      Applications/Internet
License:    ASL 2.0
URL:        https://github.com/fkooman/php-lib-json
Source0:    https://github.com/fkooman/php-lib-json/releases/download/%{version}/php-fkooman-json-%{version}.tar.xz
BuildArch:  noarch

Provides:   php-composer(fkooman/json) = %{version}

Requires:   php >= 5.3.3

%description
This is a PHP library written to make it easy and safe to process JSON.
It will throw exceptions when encoding or decoding fails.

%prep
%setup -q

%build

%install

# Application
mkdir -p ${RPM_BUILD_ROOT}%{_datadir}/php/%{name}
cp -pr src vendor ${RPM_BUILD_ROOT}%{_datadir}/php/%{name}

%files
%defattr(-,root,root,-)

%dir %{_datadir}/php/%{name}
%{_datadir}/php/%{name}/src
%{_datadir}/php/%{name}/vendor

%doc README.md CHANGES.md COPYING

%changelog
* Thu Aug 14 2014 François Kooman <fkooman@tuxed.net> - 0.4.0-1
- initial package
