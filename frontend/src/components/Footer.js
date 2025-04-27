import React from "react";
import { Link } from "react-router-dom";

const Footer = () => {
  return (
    <footer className="bg-gray-100 mt-12 py-8 px-6 border-t">
      <div className="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-sm text-gray-700">

        {/* Contact */}
        <div>
          <h3 className="font-semibold mb-2">Contact</h3>
          <p>Adresse</p>
          <p>Numéro de telepone</p>
          <p>Lun - Ven : 9h - 18h</p>
        </div>

        {/* Liens légaux */}
        <div>
          <h3 className="font-semibold mb-2">Informations</h3>
          <ul className="space-y-1">
            <li><Link to="/mentions-legales" className="hover:underline">Mentions légales</Link></li>
            <li><Link to="/cgu" className="hover:underline">Conditions générales d’utilisation</Link></li>
            <li><Link to="/confidentialite" className="hover:underline">Politique de confidentialité</Link></li>
            <li><Link to="/a-propos" className="hover:underline">À propos</Link></li>
          </ul>
        </div>

        {/* Adresse seule (mobile) */}
        <div>
          <h3 className="font-semibold mb-2">Cabinet</h3>
          <p>Centre Dentaire Farid cabinet</p>
          <p>Numéro de rue</p>
          <p>Ville, pays</p>
        </div>

      </div>

      <div className="text-center text-gray-500 text-xs mt-6">
        © {new Date().getFullYear()} Faird Cabinet. Tous droits réservés.
      </div>
    </footer>
  );
};

export default Footer;
